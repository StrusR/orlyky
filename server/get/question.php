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



    $data_server_questions = $mysqli -> query("SELECT * FROM `questions` WHERE `id` = '".$id."'");
    while (($all_questions = $data_server_questions->fetch_assoc()) != false) {
        $SuccessReturn['question'] = $all_questions;


        $data_server_answers = $mysqli -> query("SELECT * FROM `answers` WHERE `questionId` = '".$all_questions['id']."'");
        $l = 0;
        while (($all_answers = $data_server_answers->fetch_assoc()) != false) {
            $SuccessReturn['question']['answers'][$l] = $all_answers;
            $data_server_usersAnswers = $mysqli -> query("SELECT `userId` FROM `usersAnswers` WHERE `answerId` = '".$all_answers['id']."'");
            if ($data_server_usersAnswers->num_rows > 0) {
                $p = 0;
                while (($all_usersAnswers = $data_server_usersAnswers->fetch_assoc()) != false) {
                    $SuccessReturn['question']['answers'][$l]['voted'][$p] = $all_usersAnswers['userId'];
                    $p++;
                };
            } else {
                $SuccessReturn['question']['answers'][$l]['voted'] = array();;
            }
            $l++;
        };

    };


    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>