<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['id'];
    session_start();
    $myId = $_SESSION['id'];
    session_write_close();
    $accessRights = $_POST['accessRights'];

    $SuccessReturn = array();

    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $data_server = $mysqli -> query("SELECT `accessRights` FROM `users` WHERE `id` = '".$myId."'");
    while (($all = $data_server->fetch_assoc()) != false) {
        $myAccessRights = $all['accessRights'];
    };

    if ($myAccessRights == 'command') {
        if ($accessRights == 'command' || $accessRights == 'participant') {
            $data_server_news = $mysqli -> query("SELECT `id` FROM `news` WHERE `authorId` = '".$id."'");
            while (($all_news = $data_server_news->fetch_assoc()) != false) {
                $data_server_questions = $mysqli -> query("SELECT `id` FROM `questions` WHERE `newsId` = '".$all_news['id']."'");
                while (($all_questions = $data_server_questions->fetch_assoc()) != false) {
                    $mysqli -> query("DELETE FROM `answers` WHERE `questionId` = '".$all_questions['id']."'");
                    $mysqli -> query("DELETE FROM `usersAnswers` WHERE `questionId` = '".$all_questions['id']."'");
                };
                $mysqli -> query("DELETE FROM `questions` WHERE `newsId` = '".$all_news['id']."'");
            };
            $mysqli -> query("DELETE FROM `news` WHERE `authorId` = '".$id."'");
            $mysqli -> query("UPDATE `users` SET `accessRights` = '".$accessRights."' WHERE `users`.`id` = '".$id."'");

            $SuccessReturn['response'] = true;
        } else {
            $SuccessReturn['response'] = false;
        }
    } else {
        $SuccessReturn['response'] = false;
    }
    $mysqli->close ();
    echo json_encode($SuccessReturn);
}
?>