<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['id'];
    session_start();
    $myId = $_SESSION['id'];
    session_write_close();
    $accessRights = $_POST['accessRights'];

    $SuccessReturn = array();

    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $data_server = $mysqli -> query("SELECT `accessRights` FROM `users` WHERE `id` = '".$myId."'");
    while (($all = $data_server->fetch_assoc()) != false) {
        $myAccessRights = $all['accessRights'];
    };

    if ($myAccessRights == 'command') {
        if ($accessRights == 'command' || $accessRights == 'participant') {
            $mysqli -> query("UPDATE `users` SET `accessRights` = '".$accessRights."' WHERE `users`.`id` = '".$id."'");
            $SuccessReturn['response'] = true;
        } else {
            $SuccessReturn['response'] = false;
        }
    } else {
        $SuccessReturn['response'] = false;
    }
    $mysqli->close ();
    echo json_encode($SuccessReturn);
}
?>