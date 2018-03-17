<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $SuccessReturn = array();

    session_start();
    if(session_destroy()){
        $SuccessReturn["session"] = false;
    } else {
        $SuccessReturn["session"] = true;
    }
    session_write_close();

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>