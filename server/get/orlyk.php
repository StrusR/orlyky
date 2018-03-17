<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $id = $_POST['id'];
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

    $data_server = $mysqli -> query("SELECT * FROM `users` WHERE `id` = '".$id."'");
    if ($data_server->num_rows > 0) {
        $SuccessReturn['page'] = true;
        while (($all = $data_server->fetch_assoc()) != false) {
            if ($all['accessRights'] == 'statement') {
                if ($myAccessRights == 'command') {
                    $SuccessReturn['id'] = $all['id'];
                    $SuccessReturn['name'] = $all['name'];
                    $SuccessReturn['patronymic'] = $all['patronymic'];
                    $SuccessReturn['surname'] = $all['surname'];
                    $SuccessReturn['email'] = $all['email'];
                    $SuccessReturn['phone'] = $all['phone'];
                    $SuccessReturn['regDate'] = $all['regDate'];
                }
                $SuccessReturn['accessRights'] = $all['accessRights'];
            } else {
                $SuccessReturn['id'] = $all['id'];
                $SuccessReturn['name'] = $all['name'];
                $SuccessReturn['patronymic'] = $all['patronymic'];
                $SuccessReturn['surname'] = $all['surname'];
                $SuccessReturn['email'] = $all['email'];
                $SuccessReturn['phone'] = $all['phone'];
                $SuccessReturn['accessRights'] = $all['accessRights'];
                $SuccessReturn['regDate'] = $all['regDate'];
            }
        };
    }else {
        $SuccessReturn['page'] = false;
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>