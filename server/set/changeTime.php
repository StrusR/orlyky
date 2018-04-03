<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $id = $_POST['id'];
    $day = $_POST['day'];
    $hour = $_POST['hour'];
    $minute = $_POST['minute'];
    $newHour = $_POST['newHour'];
    $newMinute = $_POST['newMinute'];
    $type = $_POST['type'];
    $dishes = json_decode($_POST['dishes']);
    
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
            while (($all_dayTimes = $data_server_dayTimes->fetch_assoc()) != false) {
                $mysqli -> query("UPDATE `dayTimes` SET `hour` = '".$newHour."' WHERE `dayTimes`.`id` = '".$all_dayTimes['id']."'");
                $mysqli -> query("UPDATE `dayTimes` SET `minute` = '".$newMinute."' WHERE `dayTimes`.`id` = '".$all_dayTimes['id']."'");
                $mysqli -> query("DELETE FROM `menuDishes` WHERE `dayTimesId` = '".$all_dayTimes['id']."'");
                for ($i=0; $i < count($dishes); $i++) { 
                    $mysqli -> query("INSERT INTO `menuDishes` (`dayTimesId`, `dishId`) VALUES ('".$all_dayTimes['id']."', '".$dishes[$i]."')");
                }
                $SuccessReturn['response'] = true;
            };
        };

    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>