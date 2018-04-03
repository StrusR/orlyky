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
        $data_server_events = $mysqli -> query("SELECT * FROM `events`");
        if ($data_server_events->num_rows > 0) {
            $SuccessReturn['page'] = true;
            $i = 0;
            while (($all_events = $data_server_events->fetch_assoc()) != false) {
                $SuccessReturn['events'][$i] = $all_events;
                $i++;
            };
        }else {
            $SuccessReturn['page'] = false;
        }
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>