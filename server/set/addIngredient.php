<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $type = $_POST['type'];
    $name = $_POST['name'];
    $name=str_replace("'","\'",$name);
    $weight = $_POST['weight'];
    $price = $_POST['price'];
    $gr = $_POST['gr'];
    
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

    if ($myAccessRights == 'command' && $name != "" && $weight > 0 && $price > 0) {
        $mysqli -> query("INSERT INTO `ingredients` (`name`, `type`, `weight`, `price`, `gr`) VALUES ('".$name."', '".$type."', '".$weight."', '".$price."', '".$gr."')");

        $SuccessReturn['response'] = true;;
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>