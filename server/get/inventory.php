<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mysqli = new mysqli ("195.149.114.51", "corivkac", "gfup/kycqqs", "corivkac_orlyky");
    $mysqli -> query ("SET NAMES 'utf8'");

    session_start();
    $myId = $_SESSION['id'];
    session_write_close();
    $id = $_POST['id'];

    $SuccessReturn = array();

    if ($myId) {
        $data_server = $mysqli -> query("SELECT `accessRights` FROM `users` WHERE `id` = '".$myId."'");
        while (($all = $data_server->fetch_assoc()) != false) {
            $myAccessRights = $all['accessRights'];
        };
    }
    if ($myAccessRights == 'command') {

        $data_server_days = $mysqli -> query("SELECT * FROM `eventDays` WHERE `eventId` = '".$id."' ORDER BY `day`");
        $q = 0;
        while (($all_days = $data_server_days->fetch_assoc()) != false) {
            $SuccessReturn['days'][$q] = $all_days;
            $data_server_dishes = $mysqli -> query("SELECT `id` FROM `participantsDays` WHERE `dayId` = '".$all_days['id']."'");
            $participants = 22;     
            while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
                $participants++;
            };

            $data_server_dayTimes = $mysqli -> query("SELECT * FROM `dayTimes` WHERE `dayId` = '".$all_days['id']."' && `type` = 'menu' ORDER BY `hour`, `minute`");
            $e = 0;
            while (($all_dayTimes = $data_server_dayTimes->fetch_assoc()) != false) {
                $SuccessReturn['days'][$q]['times'][$e] = $all_dayTimes;
                $data_server_menuDishes = $mysqli -> query("SELECT * FROM `menuDishes` WHERE `dayTimesId` = '".$all_dayTimes['id']."'");
                $r = 0;
                while (($all_menuDishes = $data_server_menuDishes->fetch_assoc()) != false) {
                    
                    $data_server_dishes = $mysqli -> query("SELECT * FROM `dishes` WHERE `id` = '".$all_menuDishes['dishId']."'");
                    while (($all_dishes = $data_server_dishes->fetch_assoc()) != false) {
                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r] = $all_dishes;
                        $roundingPercentage = null;
                        // *************************************************************************************************************************************
                        $data_server_dishIngredients = $mysqli -> query("SELECT * FROM `dishIngredients` WHERE `dishId` = '".$all_menuDishes['dishId']."' && `round` = '1' ORDER BY (`weight`) DESC");
                        $t = 0;
                        while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                            $weight = $all_dishIngredients['weight']*$participants;
                            $onePercentage = $weight / 100;
                            $data_server_ingredients = $mysqli -> query("SELECT * FROM `ingredients` WHERE `id` = '".$all_dishIngredients['ingredientId']."' && `gr` = 'groat'");
                            while (($all_ingredients = $data_server_ingredients->fetch_assoc()) != false) {
                                $minWeight = $all_ingredients['weight']/2;
                                $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['groat'][$t] = $all_ingredients;
                                if ($weight < $all_ingredients['weight']/6*4) {
                                    $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['groat'][$t]['weight'] = round($weight + $onePercentage * $roundingPercentage);
                                    $roundingPercentage = 0;
                                } else {

                                    if ($roundingPercentage === null) {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['groat'][$t]['weight'] = round($weight/$minWeight)*$minWeight;
                                        $difference = round($weight/$minWeight)*$minWeight - $weight;
                                        $roundingPercentage = $difference / $onePercentage;
                                    } else {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['groat'][$t]['weight'] = round(($weight + $onePercentage * $roundingPercentage)/$minWeight)*($minWeight);
                                    }
                                }
                                $t++;
                            }; 
                        };
                        // *************************************************************************************************************************************
                        $data_server_dishIngredients = $mysqli -> query("SELECT * FROM `dishIngredients` WHERE `dishId` = '".$all_menuDishes['dishId']."' && `round` = '1' ORDER BY (`weight`) DESC");
                        $t = 0;
                        while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                            $weight = $all_dishIngredients['weight']*$participants;
                            $onePercentage = $weight / 100;
                            $data_server_ingredients = $mysqli -> query("SELECT * FROM `ingredients` WHERE `id` = '".$all_dishIngredients['ingredientId']."' && `gr` = 'canned'");
                            while (($all_ingredients = $data_server_ingredients->fetch_assoc()) != false) {
                                $minWeight = $all_ingredients['weight'];
                                $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['canned'][$t] = $all_ingredients;
                                if ($weight < $all_ingredients['weight']/6*4) {
                                    $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['canned'][$t]['weight'] = round($weight + $onePercentage * $roundingPercentage);
                                    $roundingPercentage = 0;
                                } else {

                                    if ($roundingPercentage === null) {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['canned'][$t]['weight'] = round($weight/$minWeight)*$minWeight;
                                        $difference = round($weight/$minWeight)*$minWeight - $weight;
                                        $roundingPercentage = $difference / $onePercentage;
                                    } else {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['canned'][$t]['weight'] = round(($weight + $onePercentage * $roundingPercentage)/$minWeight)*($minWeight);
                                    }
                                }
                                $t++;
                            }; 
                        };
                        // *************************************************************************************************************************************
                        $data_server_dishIngredients = $mysqli -> query("SELECT * FROM `dishIngredients` WHERE `dishId` = '".$all_menuDishes['dishId']."' && `round` = '1' ORDER BY (`weight`) DESC");
                        $t = 0;
                        while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                            $weight = $all_dishIngredients['weight']*$participants;
                            $onePercentage = $weight / 100;
                            $data_server_ingredients = $mysqli -> query("SELECT * FROM `ingredients` WHERE `id` = '".$all_dishIngredients['ingredientId']."' && `gr` = 'milk'");
                            while (($all_ingredients = $data_server_ingredients->fetch_assoc()) != false) {
                                $minWeight = $all_ingredients['weight'];
                                $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['milk'][$t] = $all_ingredients;
                                if ($weight < $all_ingredients['weight']/6*4) {
                                    $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['milk'][$t]['weight'] = round($weight + $onePercentage * $roundingPercentage);
                                    $roundingPercentage = 0;
                                } else {

                                    if ($roundingPercentage === null) {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['milk'][$t]['weight'] = round($weight/$minWeight)*$minWeight;
                                        $difference = round($weight/$minWeight)*$minWeight - $weight;
                                        $roundingPercentage = $difference / $onePercentage;
                                    } else {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['milk'][$t]['weight'] = round(($weight + $onePercentage * $roundingPercentage)/$minWeight)*($minWeight);
                                    }
                                }
                                $t++;
                            }; 
                        };
                        // *************************************************************************************************************************************
                        $data_server_dishIngredients = $mysqli -> query("SELECT * FROM `dishIngredients` WHERE `dishId` = '".$all_menuDishes['dishId']."' && `round` = '1' ORDER BY (`weight`) DESC");
                        $t = 0;
                        while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                            $weight = $all_dishIngredients['weight']*$participants;
                            $onePercentage = $weight / 100;
                            $data_server_ingredients = $mysqli -> query("SELECT * FROM `ingredients` WHERE `id` = '".$all_dishIngredients['ingredientId']."' && `gr` = 'meat'");
                            while (($all_ingredients = $data_server_ingredients->fetch_assoc()) != false) {
                                $minWeight = $all_ingredients['weight'];
                                $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['meat'][$t] = $all_ingredients;
                                if ($weight < $all_ingredients['weight']/6*4) {
                                    $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['meat'][$t]['weight'] = round($weight + $onePercentage * $roundingPercentage);
                                    $roundingPercentage = 0;
                                } else {

                                    if ($roundingPercentage === null) {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['meat'][$t]['weight'] = round($weight/$minWeight)*$minWeight;
                                        $difference = round($weight/$minWeight)*$minWeight - $weight;
                                        $roundingPercentage = $difference / $onePercentage;
                                    } else {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['meat'][$t]['weight'] = round(($weight + $onePercentage * $roundingPercentage)/$minWeight)*($minWeight);
                                    }
                                }
                                $t++;
                            }; 
                        };
                        // *************************************************************************************************************************************
                        $data_server_dishIngredients = $mysqli -> query("SELECT * FROM `dishIngredients` WHERE `dishId` = '".$all_menuDishes['dishId']."' && `round` = '1' ORDER BY (`weight`) DESC");
                        $t = 0;
                        while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                            $weight = $all_dishIngredients['weight']*$participants;
                            $onePercentage = $weight / 100;
                            $data_server_ingredients = $mysqli -> query("SELECT * FROM `ingredients` WHERE `id` = '".$all_dishIngredients['ingredientId']."' && `gr` = 'vegetable'");
                            while (($all_ingredients = $data_server_ingredients->fetch_assoc()) != false) {
                                $minWeight = $all_ingredients['weight'];
                                $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['vegetable'][$t] = $all_ingredients;
                                if ($weight < $all_ingredients['weight']/6*4) {
                                    $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['vegetable'][$t]['weight'] = round($weight + $onePercentage * $roundingPercentage);
                                    $roundingPercentage = 0;
                                } else {

                                    if ($roundingPercentage === null) {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['vegetable'][$t]['weight'] = round($weight/$minWeight)*$minWeight;
                                        $difference = round($weight/$minWeight)*$minWeight - $weight;
                                        $roundingPercentage = $difference / $onePercentage;
                                    } else {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['vegetable'][$t]['weight'] = round(($weight + $onePercentage * $roundingPercentage)/$minWeight)*($minWeight);
                                    }
                                }
                                $t++;
                            }; 
                        };
                        // *************************************************************************************************************************************
                        $data_server_dishIngredients = $mysqli -> query("SELECT * FROM `dishIngredients` WHERE `dishId` = '".$all_menuDishes['dishId']."' && `round` = '1' ORDER BY (`weight`) DESC");
                        $t = 0;
                        while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                            $weight = $all_dishIngredients['weight']*$participants;
                            $onePercentage = $weight / 100;
                            $data_server_ingredients = $mysqli -> query("SELECT * FROM `ingredients` WHERE `id` = '".$all_dishIngredients['ingredientId']."' && `gr` = 'spices'");
                            while (($all_ingredients = $data_server_ingredients->fetch_assoc()) != false) {
                                $minWeight = $all_ingredients['weight'];
                                $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['spices'][$t] = $all_ingredients;
                                if ($weight < $all_ingredients['weight']/6*4) {
                                    $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['spices'][$t]['weight'] = round($weight + $onePercentage * $roundingPercentage);
                                    $roundingPercentage = 0;
                                } else {

                                    if ($roundingPercentage === null) {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['spices'][$t]['weight'] = round($weight/$minWeight)*$minWeight;
                                        $difference = round($weight/$minWeight)*$minWeight - $weight;
                                        $roundingPercentage = $difference / $onePercentage;
                                    } else {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['spices'][$t]['weight'] = round(($weight + $onePercentage * $roundingPercentage)/$minWeight)*($minWeight);
                                    }
                                }
                                $t++;
                            }; 
                        };
                        // *************************************************************************************************************************************
                        $data_server_dishIngredients = $mysqli -> query("SELECT * FROM `dishIngredients` WHERE `dishId` = '".$all_menuDishes['dishId']."' && `round` = '1' ORDER BY (`weight`) DESC");
                        $t = 0;
                        while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                            $weight = $all_dishIngredients['weight']*$participants;
                            $onePercentage = $weight / 100;
                            $data_server_ingredients = $mysqli -> query("SELECT * FROM `ingredients` WHERE `id` = '".$all_dishIngredients['ingredientId']."' && `gr` = 'sweet'");
                            while (($all_ingredients = $data_server_ingredients->fetch_assoc()) != false) {
                                $minWeight = $all_ingredients['weight'];
                                $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['sweet'][$t] = $all_ingredients;
                                if ($weight < $all_ingredients['weight']/6*4) {
                                    $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['sweet'][$t]['weight'] = round($weight + $onePercentage * $roundingPercentage);
                                    $roundingPercentage = 0;
                                } else {

                                    if ($roundingPercentage === null) {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['sweet'][$t]['weight'] = round($weight/$minWeight)*$minWeight;
                                        $difference = round($weight/$minWeight)*$minWeight - $weight;
                                        $roundingPercentage = $difference / $onePercentage;
                                    } else {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['sweet'][$t]['weight'] = round(($weight + $onePercentage * $roundingPercentage)/$minWeight)*($minWeight);
                                    }
                                }
                                $t++;
                            }; 
                        };
                        // *************************************************************************************************************************************
                        $data_server_dishIngredients = $mysqli -> query("SELECT * FROM `dishIngredients` WHERE `dishId` = '".$all_menuDishes['dishId']."' && `round` = '1' ORDER BY (`weight`) DESC");
                        $t = 0;
                        while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                            $weight = $all_dishIngredients['weight']*$participants;
                            $onePercentage = $weight / 100;
                            $data_server_ingredients = $mysqli -> query("SELECT * FROM `ingredients` WHERE `id` = '".$all_dishIngredients['ingredientId']."' && `gr` = 'other'");
                            while (($all_ingredients = $data_server_ingredients->fetch_assoc()) != false) {
                                $minWeight = $all_ingredients['weight']/2;
                                $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['other'][$t] = $all_ingredients;
                                if ($weight < $all_ingredients['weight']/6*4) {
                                    $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['other'][$t]['weight'] = round($weight + $onePercentage * $roundingPercentage);
                                    $roundingPercentage = 0;
                                } else {

                                    if ($roundingPercentage === null) {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['other'][$t]['weight'] = round($weight/$minWeight)*$minWeight;
                                        $difference = round($weight/$minWeight)*$minWeight - $weight;
                                        $roundingPercentage = $difference / $onePercentage;
                                    } else {
                                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['other'][$t]['weight'] = round(($weight + $onePercentage * $roundingPercentage)/$minWeight)*($minWeight);
                                    }
                                }
                                $t++;
                            }; 
                        };
                        // *************************************************************************************************************************************
                        // *************************************************************************************************************************************
                        $data_server_dishIngredients = $mysqli -> query("SELECT * FROM `dishIngredients` WHERE `dishId` = '".$all_menuDishes['dishId']."' && `round` = '0' ORDER BY (`weight`) DESC");
                        $t = 0;
                        while (($all_dishIngredients = $data_server_dishIngredients->fetch_assoc()) != false) {
                            $weight = $all_dishIngredients['weight']*$participants;
                            $onePercentage = $weight / 100;
                            $data_server_ingredients = $mysqli -> query("SELECT * FROM `ingredients` WHERE `id` = '".$all_dishIngredients['ingredientId']."'");
                            while (($all_ingredients = $data_server_ingredients->fetch_assoc()) != false) {
                                $minWeight = $all_ingredients['weight']/2;
                                $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['notRounded'][$t] = $all_ingredients;
                                $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients']['notRounded'][$t]['weight'] = round($weight + $onePercentage * $roundingPercentage);
                                $t++;
                            }; 
                        };
                        // *************************************************************************************************************************************
                        // *************************************************************************************************************************************
                        $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['roundingPercentage'] =  $roundingPercentage;
                        $r++;
                    };
                };
                $e++;
            };
            
            $q++;
        };
    }

    $mysqli->close ();
    echo json_encode($SuccessReturn);
}





// if ($all_ingredients['gr'] == 'spices' || $all_ingredients['gr'] == '') {
//     $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] = $all_dishIngredients['weight']*$participants;
//  } else if ($all_ingredients['gr'] == 'groat') {
//      // if ($all_dishIngredients['weight']*$participants < $all_ingredients['weight']/6*4) {
//      //    $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] += $all_dishIngredients['weight']*$participants;
//      // } else {
//         $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] = round($all_dishIngredients['weight']*$participants/($all_ingredients['weight']/2))*($all_ingredients['weight']/2);
//      // }
//  } else if ($all_ingredients['gr'] == 'canned') {
//      // if ($all_dishIngredients['weight']*$participants < $all_ingredients['weight']/6*4) {
//      //    $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] += $all_dishIngredients['weight']*$participants;
//      // } else {
//         $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] = ceil($all_dishIngredients['weight']*$participants/$all_ingredients['weight'])*$all_ingredients['weight'];
//      // }
//  } else if ($all_ingredients['gr'] == 'meat') {
//     $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] = $all_dishIngredients['weight']*$participants;
//  } else if ($all_ingredients['gr'] == 'milk') {
//      if ($all_ingredients['type'] == 1) {
//          // if ($all_dishIngredients['weight']*$participants < $all_ingredients['weight']/6*4) {
//          //    $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] += $all_dishIngredients['weight']*$participants;
//          // } else {
//             $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] = round($all_dishIngredients['weight']*$participants/($all_ingredients['weight']/2))*($all_ingredients['weight']/2);
//          // }

//      } else if ($all_ingredients['type'] == 2) {
//         $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] = $all_dishIngredients['weight']*$participants;
//      } else {
//         $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] = ceil($all_dishIngredients['weight']*$participants);
//      }
//  } else {
//      if ($all_ingredients['type'] == 1) {
//          // if ($all_dishIngredients['weight']*$participants < $all_ingredients['weight']/6*4) {
//          //    $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] += $all_dishIngredients['weight']*$participants;
//          // } else {
//             $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] = round($all_dishIngredients['weight']*$participants/($all_ingredients['weight']/2))*($all_ingredients['weight']/2);
//          // }

//      } else if ($all_ingredients['type'] == 2) {
//         $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] = $all_dishIngredients['weight']*$participants;
//      } else {
//         $SuccessReturn['days'][$q]['times'][$e]['dishes'][$r]['ingredients'][$t]['weight'] = $all_dishIngredients['weight']*$participants;
//      }
//  }
?>