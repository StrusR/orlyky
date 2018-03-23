<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $email = trim($_POST['email']);
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $patronymic = trim($_POST['patronymic']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $rePassword = trim($_POST['rePassword']);

    $regular_email = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
    // $regular_name_surname_patronymic = '/^[а-яА-Я]{30}|[a-zA-Z]{30}$/';
    $regular_name_surname_patronymic = '/^[ЙЦУКЕНГШЩЗХЇФІВАПРОЛДЖЄЯЧСМИТЬБЮ]{2}[йцукенгшщзхїфівапролджєячсмитьбю]+$/';
    $regular_phone = '/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){12}(\s*)?$/';
    $regular_password = '/(?=.*[0-9])(?=.*[_a-zA-ZйцукенгшщзхїфівапролджєячсмитьбюЙЦУКЕНГШЩЗХЇФІВАПРОЛДЖЄЯЧСМИТЬБЮ])/';

    $auditEmail = false;
    $auditName = false;
    $auditSurname = false;
    $auditPatronymic = false;
    $auditPhone = false;
    $auditPassword = false;
    $auditRePassword = false;

    $date = time();
    $initials = $surname.' '.$name.' '.$patronymic;

    $SuccessReturn = array();
    // ********************************************************************************************
    if (preg_match($regular_email, $email)) {
        $auditEmail = true;
    };
    // ********************************************************************************************
    if (preg_match($regular_name_surname_patronymic, $name)) {
        $auditName = true;
    };
    // ********************************************************************************************
    if (preg_match($regular_name_surname_patronymic, $surname)) {
        $auditSurname = true;
    };
    // ********************************************************************************************
    if (preg_match($regular_name_surname_patronymic, $patronymic)) {
        $auditPatronymic = true;
    };
    // ********************************************************************************************
    if (preg_match($regular_phone, $phone)) {
        $auditPhone = true;
    };
    // ********************************************************************************************
    if (strlen($password) > 7 && preg_match($regular_password, $password)) {
        $auditPassword = true;
    };
    // ********************************************************************************************
    if ($password === $rePassword) {
        $auditRePassword = true;
        $password = md5($password);
    };
    // ********************************************************************************************
    $SuccessReturn['errorRegEx'] = true;
    $SuccessReturn['id'] = false;
    $SuccessReturn['errorEmail'] = false;
    $SuccessReturn['errorPhone'] = false;

    if ($auditEmail == true && $auditName == true && $auditSurname == true && $auditPatronymic == true && $auditPhone == true && $auditPassword == true && $auditRePassword == true) {
        $SuccessReturn['errorRegEx'] = false;

        $data_server_users = $mysqli -> query("SELECT `id` FROM `users` WHERE `email` = '".$email."'");
        if ($data_server_users->num_rows > 0) {
            $SuccessReturn['errorEmail'] = true;
        }

        $data_server_users = $mysqli -> query("SELECT `id` FROM `users` WHERE `phone` = '".$phone."'");
        if ($data_server_users->num_rows > 0) {
            $SuccessReturn['errorPhone'] = true;
        }
        if (!$SuccessReturn['errorEmail'] && !$SuccessReturn['errorPhone']) {
            $mysqli -> query("INSERT INTO `users` (`email`, `name`, `surname`, `patronymic`, `phone`, `password`, `regDate`, `accessRights`) VALUES ('".$email."', '".$name."', '".$surname."', '".$patronymic."', '".$phone."', '".$password."', '".$date."', 'statement')");
            $last_users_id = $mysqli->insert_id;

            $mysqli -> query("INSERT INTO `news` (`type`, `description`, `image`, `accessRights`, `date`, `authorId`) VALUES ('newProfile', 'Підтвердіть або відхиліть його заявку.', 'false', 'command', '".$date."', '".$last_users_id."')");
            $last_news_id = $mysqli->insert_id;

            $mysqli -> query("INSERT INTO `questions` (`newsId`, `question`, `type`) VALUES ('".$last_news_id."', 'Цей юнак із вашого гуртка?', '2')");
            $last_questions_id = $mysqli->insert_id;

            $mysqli -> query("INSERT INTO `answers` (`answer`, `questionId`) VALUES ('Ні', '".$last_questions_id."')");

            session_start();
            $_SESSION['id'] = $last_users_id;
            $SuccessReturn['id'] = $last_users_id;
            session_write_close();


        }
    }
    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>