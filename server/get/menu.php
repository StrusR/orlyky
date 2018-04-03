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
        $data_server_days = $mysqli -> query("SELECT * FROM `eventDays` WHERE `eventId` = '".$id."' ORDER BY `day`");
        $q = 0;
        while (($all_days = $data_server_days->fetch_assoc()) != false) {
            $SuccessReturn['days'][$q] = $all_days;
            $data_server_dayTimes = $mysqli -> query("SELECT * FROM `dayTimes` WHERE `dayId` = '".$all_days['id']."' && `type` = 'menu' ORDER BY `hour`, `minute`");
            $w = 0;
            while (($all_dayTimes = $data_server_dayTimes->fetch_assoc()) != false) {
                $SuccessReturn['days'][$q]['times'][$w] = $all_dayTimes;
                $data_server_menuDishes = $mysqli -> query("SELECT * FROM `menuDishes` WHERE `dayTimesId` = '".$all_dayTimes['id']."'");
                while (($all_menuDishes = $data_server_menuDishes->fetch_assoc()) != false) {
                    $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `id` = '".$all_menuDishes['dishId']."' && `type` = 'breakfast'");
                    $e = 0;
                    while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
                        $SuccessReturn['days'][$q]['times'][$w]['dishes']['breakfasts'][$e] = $all_dishes;
                        $e++;
                    };
                    $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `id` = '".$all_menuDishes['dishId']."' && `type` = 'firstDish'");
                    $e = 0;
                    while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
                        $SuccessReturn['days'][$q]['times'][$w]['dishes']['firstDishes'][$e] = $all_dishes;
                        $e++;
                    };
                    $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `id` = '".$all_menuDishes['dishId']."' && `type` = 'mainDish'");
                    $e = 0;
                    while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
                        $SuccessReturn['days'][$q]['times'][$w]['dishes']['mainDishes'][$e] = $all_dishes;
                        $e++;
                    };
                    $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `id` = '".$all_menuDishes['dishId']."' && `type` = 'garnish'");
                    $e = 0;
                    while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
                        $SuccessReturn['days'][$q]['times'][$w]['dishes']['garnishes'][$e] = $all_dishes;
                        $e++;
                    };
                    $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `id` = '".$all_menuDishes['dishId']."' && `type` = 'salad'");
                    $e = 0;
                    while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
                        $SuccessReturn['days'][$q]['times'][$w]['dishes']['salads'][$e] = $all_dishes;
                        $e++;
                    };
                    $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `id` = '".$all_menuDishes['dishId']."' && `type` = 'drink'");
                    $e = 0;
                    while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
                        $SuccessReturn['days'][$q]['times'][$w]['dishes']['drinks'][$e] = $all_dishes;
                        $e++;
                    };
                    $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `id` = '".$all_menuDishes['dishId']."' && `type` = 'sweet'");
                    $e = 0;
                    while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
                        $SuccessReturn['days'][$q]['times'][$w]['dishes']['sweets'][$e] = $all_dishes;
                        $e++;
                    };
                };
                $w++;
            };
            $q++;
        };
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>