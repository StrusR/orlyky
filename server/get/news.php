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
    $data_server_news = $mysqli -> query("SELECT * FROM `news` WHERE `accessRights` = '".$myAccessRights."' || `accessRights` = 'participant'");
    if ($data_server_news->num_rows > 0) {
        $SuccessReturn['page'] = true;
        $i = 0;
        while (($all_news = $data_server_news->fetch_assoc()) != false) {
            $SuccessReturn['news'][$i] = $all_news;

            if ($all_news['authorId'] > 0) {



                $data_server_users = $mysqli -> query("SELECT * FROM `users` WHERE `id` = '".$all_news['authorId']."'");
                while (($all_users = $data_server_users->fetch_assoc()) != false) {
                    $SuccessReturn['news'][$i]['authorSurname'] = $all_users['surname'];
                    $SuccessReturn['news'][$i]['authorName'] = $all_users['name'];
                    $SuccessReturn['news'][$i]['authorPatronymic'] = $all_users['patronymic'];
                };



            }
            // if ($all_news['type'] == 'newProfile' ) {


                $data_server_questions = $mysqli -> query("SELECT * FROM `questions` WHERE `newsId` = '".$all_news['id']."'");
                $j = 0;
                while (($all_questions = $data_server_questions->fetch_assoc()) != false) {
                    $SuccessReturn['news'][$i]['questions'][$j] = $all_questions;



                    $data_server_answers = $mysqli -> query("SELECT * FROM `answers` WHERE `questionId` = '".$all_questions['id']."'");
                    $l = 0;
                    while (($all_answers = $data_server_answers->fetch_assoc()) != false) {
                        $SuccessReturn['news'][$i]['questions'][$j]['answers'][$l] = $all_answers;



                        $data_server_usersAnswers = $mysqli -> query("SELECT `userId` FROM `usersAnswers` WHERE `answerId` = '".$all_answers['id']."'");
                        if ($data_server_usersAnswers->num_rows > 0) {
                            $p = 0;
                            while (($all_usersAnswers = $data_server_usersAnswers->fetch_assoc()) != false) {
                                $SuccessReturn['news'][$i]['questions'][$j]['answers'][$l]['voted'][$p] = $all_usersAnswers['userId'];
                                $p++;
                            };
                        } else {
                            $SuccessReturn['news'][$i]['questions'][$j]['answers'][$l]['voted'] = array();
                        }
                        $l++;
                    };

                    
                    $data_server_usersAnswers = $mysqli -> query("SELECT `answerId` FROM `usersAnswers` WHERE `questionId` = '".$all_questions['id']."' && `userId` = '".$myId."'");
                    if ($data_server_usersAnswers->num_rows > 0) {
                        $g = 0;
                        while (($all_usersAnswers = $data_server_usersAnswers->fetch_assoc()) != false) {
                            $SuccessReturn['news'][$i]['questions'][$j]['myAnswers'][$g] = $all_usersAnswers['answerId'];
                            $g++;
                        };
                    } else {
                        $SuccessReturn['news'][$i]['questions'][$j]['myAnswers'] = array();
                    }
                    $j++;
                };
            // }



            $data_server_users = $mysqli -> query("SELECT `id` FROM `users` WHERE `accessRights` = '".$all_news['accessRights']."' || `accessRights` = 'command'");
            $t = 0;
            while (($all_users = $data_server_users->fetch_assoc()) != false) {
                $SuccessReturn['news'][$i]['users'][$t] = $all_users['id'];
                $t++;
            };
            $i++;
        };
    }else {
        $SuccessReturn['page'] = false;
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>