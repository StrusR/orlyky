<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    session_start();
    $myId = $_SESSION['id'];
    session_write_close();

    $SuccessReturn = array();

    if ($myId) {
        $data_server = $mysqli -> query("SELECT * FROM `users` WHERE `id` = '".$myId."'");
        while (($all = $data_server->fetch_assoc()) != false) {
            $SuccessReturn['id'] = $all['id'];
            $SuccessReturn['name'] = $all['name'];
            $SuccessReturn['patronymic'] = $all['patronymic'];
            $SuccessReturn['surname'] = $all['surname'];
            $SuccessReturn['email'] = $all['email'];
            $SuccessReturn['phone'] = $all['phone'];
            $SuccessReturn['accessRights'] = $all['accessRights'];
            $SuccessReturn['regDate'] = $all['regDate'];
        };
    } else {
        $SuccessReturn['id'] = false;
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>