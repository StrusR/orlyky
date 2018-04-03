<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    session_start();
    $myId = $_SESSION['id'];
    session_write_close();
    $id = $_POST['id'];

    $SuccessReturn = array();

    if ($myId) {
        $data_server = $mysqli -> query("SELECT `accessRights` FROM `users` WHERE `id` = '".$myId."'");
        while (($all = $data_server->fetch_assoc()) != false) {
            $myAccessRights = $all['accessRights'];
        };
    }
    if ($myAccessRights == 'command') {
        $data_server_event = $mysqli -> query("SELECT * FROM `events` WHERE `id` = '".$id."'");
        if ($data_server_event->num_rows > 0) {
            $SuccessReturn['page'] = true;
            while (($all_event = $data_server_event->fetch_assoc()) != false) {
                $SuccessReturn['event'] = $all_event;
            };
        }else {
            $SuccessReturn['page'] = false;
        }
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>