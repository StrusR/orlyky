<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $id = $_POST['id'];
    $day = $_POST['day'];
    $hour = $_POST['hour'];
    $minute = $_POST['minute'];
    
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


    if ($myAccessRights == 'command') {
        $data_server_eventDays = $mysqli -> query("SELECT * FROM `eventDays` WHERE `eventId` = '".$id."' && `day` = '".$day."'");
        while (($all_eventDays = $data_server_eventDays->fetch_assoc()) != false) {
            $data_server_dayTimes = $mysqli -> query("SELECT * FROM `dayTimes` WHERE `dayId` = '".$all_eventDays['id']."' && `hour` = '".$hour."' && `minute` = '".$minute."'");
            while (($all_dayTimes = $data_server_dayTimes->fetch_assoc()) != false) {
                $mysqli -> query("DELETE FROM `menuDishes` WHERE `dayTimesId` = '".$all_dayTimes['id']."'");
            };
            $mysqli -> query("DELETE FROM `dayTimes` WHERE `dayId` = '".$all_eventDays['id']."' && `hour` = '".$hour."' && `minute` = '".$minute."'");
            $SuccessReturn['response'] = true;
        };

    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>