<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    session_start();
    $myId = $_SESSION['id'];
    session_write_close();
    $id = $_POST['id'];

    $SuccessReturn = array();

    if ($myId) {
        $data_server = $mysqli -> query("SELECT `accessRights` FROM `users` WHERE `id` = '".$myId."'");
        while (($all = $data_server->fetch_assoc()) != false) {
            $myAccessRights = $all['accessRights'];
        };
    }
    if ($myAccessRights == 'command') {
        $data_server_evantParticipants = $mysqli -> query("SELECT * FROM `evantParticipants` WHERE `eventId` = '".$id."'");
        $q=0;
        while (($all_evantParticipants = $data_server_evantParticipants->fetch_assoc()) != false) {
            $data_server_user = $mysqli -> query("SELECT `id`, `name`, `surname` FROM `users` WHERE `id` = '".$all_evantParticipants['userId']."'");
            while (($all_user = $data_server_user->fetch_assoc()) != false) {
                $SuccessReturn['eventParticipants'][$q]['user'] = $all_user;
            };
            
            $data_server_eventDays = $mysqli -> query("SELECT `id` FROM `eventDays` WHERE `eventId` = '".$id."' ORDER BY `day`");
            $w=0;
            while (($all_eventDays = $data_server_eventDays->fetch_assoc()) != false) {
                $data_server_participantsDays = $mysqli -> query("SELECT `dayId` FROM `participantsDays` WHERE `participantsId` = '".$all_evantParticipants['id']."'");
                $e=0;
                $SuccessReturn['eventParticipants'][$q]['days'][$w] = false;
                while (($all_participantsDays = $data_server_participantsDays->fetch_assoc()) != false) {
                    if ($all_participantsDays['dayId'] == $all_eventDays['id']) {
                        $SuccessReturn['eventParticipants'][$q]['days'][$w] = true;
                    }
                    $e++;
                };
                $w++;
            };
            $q++;
        };
        $data_server = $mysqli -> query("SELECT * FROM `users`");
        while (($all = $data_server->fetch_assoc()) != false) {
            $friend['id'] = $all['id'];
            $friend['name'] = $all['name'];
            $friend['surname'] = $all['surname'];

            $SuccessReturn['friends'][$i] = $friend;
            $i++;
        };
        $data_server_eventDays = $mysqli -> query("SELECT `id` FROM `eventDays` WHERE `eventId` = '".$id."' ORDER BY `day`");
        $d=0;
        while (($all_eventDays = $data_server_eventDays->fetch_assoc()) != false) {
            $d++;
        };
        $SuccessReturn['days'] = $d;
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}
?>