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
        $data_server_ingredients = $mysqli -> query("SELECT * FROM `ingredients`");
        $q=0;
        while (($all_ingredients = $data_server_ingredients->fetch_assoc()) != false) {
            $SuccessReturn['ingredients'][$q] = $all_ingredients;
            $q++;
        };
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}
?>