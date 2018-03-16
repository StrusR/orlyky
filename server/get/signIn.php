<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $login = $_POST['login'];
    $password = md5($_POST['password']);

    $SuccessReturn = array();

    $data_server = $mysqli -> query("SELECT `id` FROM `users` WHERE `email` = '".$login."' && `password` = '".$password."' || `phone` = '".$login."' && `password` = '".$password."'");
    if ($data_server->num_rows > 0) {
        while (($all = $data_server->fetch_assoc()) != false) {
            session_start();
            $_SESSION['id'] = $all['id'];
            $SuccessReturn['id'] = $all['id'];
            session_write_close();
        };
    }else {
        $SuccessReturn['id'] = false;
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>