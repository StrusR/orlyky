<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $id = $_POST['id'];
    
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
        $mysqli -> query("DELETE FROM `dishes` WHERE `id` = '".$id."'");
        $mysqli -> query("DELETE FROM `dishIngredients` WHERE `dishId` = '".$id."'");
        $mysqli -> query("DELETE FROM `menuDishes` WHERE `dishId` = '".$id."'");

        $SuccessReturn['response'] = true;
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>