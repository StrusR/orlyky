<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    // $topic = $_POST['topic'];
    // $description = $_POST['description'];
    $id = $_POST['id'];
    $day = $_POST['day'];
    $hour = $_POST['hour'];
    $minute = $_POST['minute'];
    $type = $_POST['type'];
    
    session_start();
    $myId = $_SESSION['id'];
    session_write_close();

    $SuccessReturn = array();
    $SuccessReturn['response'] = false;


    if ($myId) {
        $data_server = $mysqli -> query("SELECT `accessRights` FROM `users` WHERE `id` = '".$myId."'");
        while (($all = $data_server->fetch_assoc()) != false) {
            $myAccessRights = $all['accessRights'];
        };
    }


    if ($myAccessRights == 'command' && $hour <= 23 && $minute <= 55) {
        $data_server_eventDays = $mysqli -> query("SELECT * FROM `eventDays` WHERE `eventId` = '".$id."' && `day` = '".$day."'");
        while (($all_eventDays = $data_server_eventDays->fetch_assoc()) != false) {
            $data_server_dayTimes = $mysqli -> query("SELECT * FROM `dayTimes` WHERE `dayId` = '".$all_eventDays['id']."' && `hour` = '".$hour."' && `minute` = '".$minute."'");
            if ($data_server_dayTimes->num_rows == 0) {
                $mysqli -> query("INSERT INTO `dayTimes` (`dayId`, `hour`, `minute`, `type`) VALUES ('".$all_eventDays['id']."', '".$hour."', '".$minute."', '".$type."')");
                $SuccessReturn['response'] = true;
            }
        };

    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>