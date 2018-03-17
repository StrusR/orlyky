<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    session_start();
    $myId = $_SESSION['id'];
    session_write_close();

    $SuccessReturn = array();

    $i = 0;

    if ($myId) {
        $data_server = $mysqli -> query("SELECT `accessRights` FROM `users` WHERE `id` = '".$myId."'");
        while (($all = $data_server->fetch_assoc()) != false) {
            $myAccessRights = $all['accessRights'];
        };
    }

    if ($myAccessRights == 'command') {
        $data_server = $mysqli -> query("SELECT * FROM `users` WHERE `id` != '".$myId."'");
        while (($all = $data_server->fetch_assoc()) != false) {
            $friend['id'] = $all['id'];
            $friend['name'] = $all['name'];
            $friend['patronymic'] = $all['patronymic'];
            $friend['surname'] = $all['surname'];
            $friend['email'] = $all['email'];
            $friend['phone'] = $all['phone'];
            $friend['regDate'] = $all['regDate'];
            $friend['accessRights'] = $all['accessRights'];

            $SuccessReturn[$i] = $friend;
            $i++;
        };

    } else if ($myAccessRights == 'participant') {
        $data_server = $mysqli -> query("SELECT * FROM `users` WHERE `id` != '".$myId."' && `accessRights` != 'statement'");

        while (($all = $data_server->fetch_assoc()) != false) {
            $friend['id'] = $all['id'];
            $friend['name'] = $all['name'];
            $friend['patronymic'] = $all['patronymic'];
            $friend['surname'] = $all['surname'];
            $friend['email'] = $all['email'];
            $friend['phone'] = $all['phone'];
            $friend['regDate'] = $all['regDate'];
            $friend['accessRights'] = $all['accessRights'];

            $SuccessReturn[$i] = $friend;
            $i++;
        };
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>