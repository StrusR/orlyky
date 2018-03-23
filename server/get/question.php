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
                $SuccessReturn['question']['answers'][$l]['voted'] = false;
            }
            $l++;
        };



        $data_server_usersAnswers = $mysqli -> query("SELECT `answerId` FROM `usersAnswers` WHERE `questionId` = '".$all_questions['id']."' && `userId` = '".$myId."'");
        if ($data_server_usersAnswers->num_rows > 0) {
            $g = 0;
            while (($all_usersAnswers = $data_server_usersAnswers->fetch_assoc()) != false) {
                $SuccessReturn['question']['usersAnswers'][$g] = $all_usersAnswers['answerId'];
                $g++;
            };
        } else {
            $SuccessReturn['question']['usersAnswers'] = array();
        }



        $data_server_news = $mysqli -> query("SELECT `accessRights` FROM `news` WHERE `id` = '".$all_questions['newsId']."'");
        while (($all_news = $data_server_news->fetch_assoc()) != false) {
            $data_server_users = $mysqli -> query("SELECT `id` FROM `users` WHERE `accessRights` = '".$all_news['accessRights']."'");
            $i = 0;
            while (($all_users = $data_server_users->fetch_assoc()) != false) {
                $SuccessReturn['users'][$i] = $all_users['id'];
                $i++;
            };
        };
    };


    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>