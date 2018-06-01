<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    session_start();
    $myId = $_SESSION['id'];
    session_write_close();
    $ret = $_POST['ret'];

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
            $SuccessReturn['dishes']['breakfast'][$q] = $all_dishes;
            if ($ret == 'all') {
                $data_server_dishIngredients = $mysqli -> query("SELECT `dishId`, `ingredientId`, `weight`, `round` FROM `dishIngredients` WHERE `dishId` = '".$all_dishes['id']."'");
                $w = 0;
                while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                    $SuccessReturn['dishes']['breakfast'][$q]['dishIngredients'][$w] = $all_dishIngredients;
                    $w++;
                };
            }
            $q++;
        };
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'firstDish'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['firstDish'][$q] = $all_dishes;
            if ($ret == 'all') {
                $data_server_dishIngredients = $mysqli -> query("SELECT `dishId`, `ingredientId`, `weight`, `round` FROM `dishIngredients` WHERE `dishId` = '".$all_dishes['id']."'");
                $w = 0;
                while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                    $SuccessReturn['dishes']['firstDish'][$q]['dishIngredients'][$w] = $all_dishIngredients;
                    $w++;
                };
            }
            $q++;
        };
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'mainDish'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['mainDish'][$q] = $all_dishes;
            if ($ret == 'all') {
                $data_server_dishIngredients = $mysqli -> query("SELECT `dishId`, `ingredientId`, `weight`, `round` FROM `dishIngredients` WHERE `dishId` = '".$all_dishes['id']."'");
                $w = 0;
                while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                    $SuccessReturn['dishes']['mainDish'][$q]['dishIngredients'][$w] = $all_dishIngredients;
                    $w++;
                };
            }
            $q++;
        };
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'garnish'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['garnish'][$q] = $all_dishes;
            if ($ret == 'all') {
                $data_server_dishIngredients = $mysqli -> query("SELECT `dishId`, `ingredientId`, `weight`, `round` FROM `dishIngredients` WHERE `dishId` = '".$all_dishes['id']."'");
                $w = 0;
                while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                    $SuccessReturn['dishes']['garnish'][$q]['dishIngredients'][$w] = $all_dishIngredients;
                    $w++;
                };
            }
            $q++;
        };
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'salad'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['salad'][$q] = $all_dishes;
            if ($ret == 'all') {
                $data_server_dishIngredients = $mysqli -> query("SELECT `dishId`, `ingredientId`, `weight`, `round` FROM `dishIngredients` WHERE `dishId` = '".$all_dishes['id']."'");
                $w = 0;
                while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                    $SuccessReturn['dishes']['salad'][$q]['dishIngredients'][$w] = $all_dishIngredients;
                    $w++;
                };
            }
            $q++;
        };
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'appetizer'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['appetizer'][$q] = $all_dishes;
            if ($ret == 'all') {
                $data_server_dishIngredients = $mysqli -> query("SELECT `dishId`, `ingredientId`, `weight`, `round` FROM `dishIngredients` WHERE `dishId` = '".$all_dishes['id']."'");
                $w = 0;
                while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                    $SuccessReturn['dishes']['appetizer'][$q]['dishIngredients'][$w] = $all_dishIngredients;
                    $w++;
                };
            }
            $q++;
        };
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'drink'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['drink'][$q] = $all_dishes;
            if ($ret == 'all') {
                $data_server_dishIngredients = $mysqli -> query("SELECT `dishId`, `ingredientId`, `weight`, `round` FROM `dishIngredients` WHERE `dishId` = '".$all_dishes['id']."'");
                $w = 0;
                while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                    $SuccessReturn['dishes']['drink'][$q]['dishIngredients'][$w] = $all_dishIngredients;
                    $w++;
                };
            }
            $q++;
        };
        $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `type` = 'sweet'");
        $q = 0;
        while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
            $SuccessReturn['dishes']['sweet'][$q] = $all_dishes;
            if ($ret == 'all') {
                $data_server_dishIngredients = $mysqli -> query("SELECT `dishId`, `ingredientId`, `weight`, `round` FROM `dishIngredients` WHERE `dishId` = '".$all_dishes['id']."'");
                $w = 0;
                while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                    $SuccessReturn['dishes']['sweet'][$q]['dishIngredients'][$w] = $all_dishIngredients;
                    $w++;
                };
            }
            $q++;
        };
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}
?>