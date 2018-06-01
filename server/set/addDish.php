<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    $type = $_POST['type'];
    $name = $_POST['name'];
    $ingredients = json_decode($_POST['ingredients']);
    
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

    if ($myAccessRights == 'command' && $name != "") {
        $mysqli -> query("INSERT INTO `dishes` (`name`, `type`) VALUES ('".$name."', '".$type."')");
        $last_dishes_id = $mysqli->insert_id;
        for ($i=0; $i < count($ingredients); $i++) { 
            if ($ingredients[$i]->weight != 0) {
                $mysqli -> query("INSERT INTO `dishIngredients` (`dishId`, `ingredientId`, `weight`, `round`) VALUES ('".$last_dishes_id."', '".$ingredients[$i]->ingredientId."', '".$ingredients[$i]->weight."', '".$ingredients[$i]->round."')");
            }
        }

        $SuccessReturn['response'] = true;
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}

?>