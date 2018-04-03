<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    session_start();
    $myId = $_SESSION['id'];
    session_write_close();

    $SuccessReturn = array();

    if ($myId) {
        $data_server = $mysqli -> query("SELECT `accessRights` FROM `users` WHERE `id` = '".$myId."'");
        while (($all = $data_server->fetch_assoc()) != false) {
            $myAccessRights = $all['accessRights'];
        };
    }
    if ($myAccessRights == 'command') {
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'breakfast'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['breakfasts'][$q] = $all_dishes;
            $q++;
        };
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'firstDish'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['firstDishes'][$q] = $all_dishes;
            $q++;
        };
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'mainDish'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['mainDishes'][$q] = $all_dishes;
            $q++;
        };
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'garnish'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['garnishes'][$q] = $all_dishes;
            $q++;
        };
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'salad'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['salads'][$q] = $all_dishes;
            $q++;
        };
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'drink'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['drinks'][$q] = $all_dishes;
            $q++;
        };
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'sweet'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['sweets'][$q] = $all_dishes;
            $q++;
        };
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>