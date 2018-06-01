<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $id = $_POST['id'];
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

    if ($myAccessRights == 'command' && $name != "") {
        $mysqli -> query("UPDATE `ingredients` SET `name` = '".$name."' WHERE `ingredients`.`id` = '".$id."'");
        $mysqli -> query("UPDATE `ingredients` SET `type` = '".$type."' WHERE `ingredients`.`id` = '".$id."'");
        $mysqli -> query("UPDATE `ingredients` SET `weight` = '".$weight."' WHERE `ingredients`.`id` = '".$id."'");
        $mysqli -> query("UPDATE `ingredients` SET `price` = '".$price."' WHERE `ingredients`.`id` = '".$id."'");
        $mysqli -> query("UPDATE `ingredients` SET `gr` = '".$gr."' WHERE `ingredients`.`id` = '".$id."'");

        $SuccessReturn['response'] = true;
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>