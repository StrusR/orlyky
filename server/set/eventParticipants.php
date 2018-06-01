<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    session_start();
    $myId = $_SESSION['id'];
    session_write_close();

    $id = $_POST['id'];
    $eventParticipants = json_decode($_POST['eventParticipants']);

    $SuccessReturn = array();

    if ($myId) {
        $data_server = $mysqli -> query("SELECT `accessRights` FROM `users` WHERE `id` = '".$myId."'");
        while (($all = $data_server->fetch_assoc()) != false) {
            $myAccessRights = $all['accessRights'];
        };
    }
    if ($myAccessRights == 'command') {
        $data_server_evantParticipants = $mysqli -> query("SELECT `id` FROM `evantParticipants` WHERE `eventId` = '".$id."'");
        $q=0;
        while (($all_evantParticipants = $data_server_evantParticipants->fetch_assoc()) != false) {
            $mysqli -> query("DELETE FROM `participantsDays` WHERE `participantsId` = '".$all_evantParticipants['id']."'");
        };
        $mysqli -> query("DELETE FROM `evantParticipants` WHERE `eventId` = '".$id."'");
        for ($i=0; $i < count($eventParticipants); $i++) { 
            $mysqli -> query("INSERT INTO `evantParticipants` (`userId`, `eventId`) VALUES ('".$eventParticipants[$i]->user->id."', '".$id."')");
            $last_evantParticipants_id = $mysqli->insert_id;
            $data_server_eventDays = $mysqli -> query("SELECT `id` FROM `eventDays` WHERE `eventId` = '".$id."' ORDER BY `day`");
            $w=0;
            while (($all_eventDays = $data_server_eventDays->fetch_assoc()) != false) {
                if ($eventParticipants[$i]->days[$w]) {
                    $mysqli -> query("INSERT INTO `participantsDays` (`participantsId`, `dayId`) VALUES ('".$last_evantParticipants_id."', '".$all_eventDays['id']."')");
                }
                $w++;
            };
        }
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>