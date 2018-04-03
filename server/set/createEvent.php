<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $topic = $_POST['topic'];
    $description = $_POST['description'];

    $selectedYearFrom = $_POST['selectedYearFrom'];
    $selectedMonthFrom = $_POST['selectedMonthFrom'];
    $selectedDayFrom = $_POST['selectedDayFrom'];
    $selectedYearTo = $_POST['selectedYearTo'];
    $selectedMonthTo = $_POST['selectedMonthTo'];
    $selectedDayTo = $_POST['selectedDayTo'];

    $dFrom = new DateTime();
    $dFrom->setDate($selectedYearFrom, $selectedMonthFrom, $selectedDayFrom);
    $dTo = new DateTime();
    $dTo->setDate($selectedYearTo, $selectedMonthTo, $selectedDayTo);
    
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
    $SuccessReturn['topic'] = true;
    $data_server = $mysqli -> query("SELECT `id` FROM `events` WHERE `topic` = '".$topic."'");
    while (($all = $data_server->fetch_assoc()) != false) {
        $SuccessReturn['topic'] = false;
    };


    if ($myAccessRights == 'command' && $SuccessReturn['topic'] && $topic != '' && $dFrom <= $dTo) {
        $mysqli -> query("INSERT INTO `events` (`topic`, `description`, `yearFrom`, `monthFrom`, `dayFrom`, `yearTo`, `monthTo`, `dayTo`, `authorId`, `dateCreated`) VALUES ('".$topic."', '".$description."', '".$selectedYearFrom."', '".$selectedMonthFrom."', '".$selectedDayFrom."', '".$selectedYearTo."', '".$selectedMonthTo."', '".$selectedDayTo."', '".$myId."', '".time()."')");
        $last_events_id = $mysqli->insert_id;
        $SuccessReturn['id'] = $last_events_id;

        $dFrom = mktime(1, 2, 3, $selectedMonthFrom + 1, $selectedDayFrom, $selectedYearFrom);
        $dTo = mktime(1, 2, 3, $selectedMonthTo + 1, $selectedDayTo, $selectedYearTo);

        $days = date("d", $dTo - $dFrom);

        for ($d=1; $d <= $days; $d++) { 
            $mysqli -> query("INSERT INTO `eventDays` (`eventId`, `day`) VALUES ('".$last_events_id."', '".$d."')");
        }


        $SuccessReturn['response'] = true;
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>