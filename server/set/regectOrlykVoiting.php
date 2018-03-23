<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['id'];
    session_start();
    $myId = $_SESSION['id'];
    session_write_close();

    $SuccessReturn = array();

    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $data_server = $mysqli -> query("SELECT `accessRights` FROM `users` WHERE `id` = '".$myId."'");
    while (($all = $data_server->fetch_assoc()) != false) {
        $myAccessRights = $all['accessRights'];
    };

    if ($myAccessRights == 'command') {
        $data_server_news = $mysqli -> query("SELECT `id` FROM `news` WHERE `authorId` = '".$id."'");
        while (($all_news = $data_server_news->fetch_assoc()) != false) {
            $data_server_questions = $mysqli -> query("SELECT `id` FROM `questions` WHERE `newsId` = '".$all_news['id']."'");
            while (($all_questions = $data_server_questions->fetch_assoc()) != false) {
                $data_server_answers = $mysqli -> query("SELECT `id` FROM `answers` WHERE `questionId` = '".$all_questions['id']."'");
                while (($all_answers = $data_server_answers->fetch_assoc()) != false) {
                    $mysqli -> query("DELETE FROM `usersAnswers` WHERE `userId` = '".$myId."' && `questionId` = '".$all_questions['id']."'");
                    $mysqli -> query("INSERT INTO `usersAnswers` (`userId`, `questionId`, `answerId`) VALUES ('".$myId."', '".$all_questions['id']."', '".$all_answers['id']."')");
                };
                // $mysqli -> query("DELETE FROM `usersAnswers` WHERE `userId` = '".$myId."' && `questionId` = '".$all_questions['id']."'");
                // $mysqli -> query("INSERT INTO `usersAnswers` (`userId`, `questionId`, `answerId`) VALUES ('".$myId."', '".$all_questions['id']."', '".$answerId[0]."')");
            };
        };
        $SuccessReturn['response'] = $id;
    } else {
        $SuccessReturn['response'] = false;
    }
    $mysqli->close ();
    echo json_encode($SuccessReturn);
}
?>