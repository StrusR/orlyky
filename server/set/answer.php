<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $answerId = json_decode($_POST['answerId']);
    $questionId = $_POST['questionId'];
    
    session_start();
    $myId = $_SESSION['id'];
    session_write_close();

    $SuccessReturn = array();
    $SuccessReturn['response'] = false;

    if ($myId) {
        $data_server = $mysqli -> query("SELECT `accessRights` FROM `users` WHERE `id` = '".$myId."'");
        while (($all = $data_server->fetch_assoc()) != false) {
            $myAccessRights = $all['accessRights'];
        };
    }
        $data_server_questions = $mysqli -> query("SELECT * FROM `questions` WHERE `id` = '".$questionId."'");
        while (($all_questions = $data_server_questions->fetch_assoc()) != false) {
            $data_server_news = $mysqli -> query("SELECT `accessRights` FROM `news` WHERE `id` = '".$all_questions['newsId']."'");
            while (($all_news = $data_server_news->fetch_assoc()) != false) {
                if ($myAccessRights == $all_news['accessRights'] || $myAccessRights == "command") {
                    $mysqli -> query("DELETE FROM `usersAnswers` WHERE `userId` = '".$myId."' && `questionId` = '".$all_questions['id']."'");
                    for ($f=0; $f < count($answerId); $f++) { 
                        $mysqli -> query("INSERT INTO `usersAnswers` (`userId`, `questionId`, `answerId`) VALUES ('".$myId."', '".$all_questions['id']."', '".$answerId[$f]."')");
                    }
                    $SuccessReturn['response'] = true;
                }
            };
        };

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>