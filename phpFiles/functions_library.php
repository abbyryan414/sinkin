<?php



// This function inputs a string, and goes back 1 directory
// Eg: changes Marco/Deck1/Deck3/ to Marco/Deck1/
// MUST HAVE "/" in the end, eg: can't have Marco/Deck1
function back_one_dir($current_dir) {
  //remove the last character of the string
  $current_path_trimmed = substr($current_dir, 0, -1);

  //Reverse the order of the string
  $current_path_reversed = "";
  $len = strlen($current_path_trimmed);
  for($i=$len; $i > 0; $i--){
    $current_path_reversed .= $current_path_trimmed[$i-1];
  }


  //removes everything before(and including) the first "/"
  $out = substr(strstr($current_path_reversed, '/'), strlen('/'));
  
  
  //Reverse the order of the string
  $current_path_reversed = "";
  $len = strlen($out);
  for($i=$len; $i > 0; $i--){
    $current_path_reversed .= $out[$i-1];
  }
  $new_path = $current_path_reversed."/";
  return $new_path;
}

//Gets last directory
//Eg: Marco/Home/Deck1/ -> Deck1
// input MUST contain "/" in the end of path
function getLastDir($current_dir) {
  //remove the last character of the string
  $current_path_trimmed = substr($current_dir, 0, -1);
  
  //Reverse the order of the string
  $current_path_reversed = "";
  $len = strlen($current_path_trimmed);
  for($i=$len; $i > 0; $i--){
    $current_path_reversed .= $current_path_trimmed[$i-1];
  }
  $out = strtok($current_path_reversed, '/');
  //Reverse the order of the string
  $current_path_reversed = "";
  $len = strlen($out);
  for($i=$len; $i > 0; $i--){
    $current_path_reversed .= $out[$i-1];
  }
  return $current_path_reversed;
}


function getLocalTime($gmt_int) {
  //is the time at GMT +0
  $gmt_date = gmdate('Y-m-d H:i:s');

  //change $gmt_date to local time
  $gmt_date = date('Y-m-d H:i:s', strtotime($gmt_date . '+'.$gmt_int.'hour'));
  
  return $gmt_date;
  // return ('2021-01-20 08:40:01');
}


//This function inputs the rep value of the card (eg: 3),
//and outputs the interval (eg: 2)
function get_interval($reps) {
  if ($reps > 20) {
    $reps = 20;
  }

  //$fibonacci[1] is 1 for good reason, don't change it
  $fibonacci = [0, 1, 1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377, 610, 987, 1597, 2584, 4181, 6765];
  $interval = $fibonacci[$reps];
  return $interval;
}

//inputs string of local_time and reps value of card, 
// outputs date(not string) of new study date
function new_study_date($reps) {

  $date_string = getLocalTime($_SESSION['gmt_int']);

  $local_time_dt = new DateTime($date_string);
  $local_time_dt_string = $local_time_dt->format('Y/m/d H:i:s');

  //-1 means he got card wrong
  if ($reps == -1) {
    //add 1 minute if got answer wrong
    return $local_time_dt->add(new DateInterval('PT1M'));

  } else if (($reps == 0) or ($reps == 1)) {
    //add 10 minutes 
    return $local_time_dt->add(new DateInterval('PT10M'));
  } else {
    //Local Date Time to Local Time string
    $local_time_string = $local_time_dt->format('H:i:s');

    if (strtotime($local_time_string) < strtotime("3AM")) {
      //same date, 3AM
      $local_time_dt->setTime(03, 00);
    } else {
      //+1 day, 3AM
      $local_time_dt->setTime(03, 00);
      $local_time_dt->add(new DateInterval('P1D'));
    }
    $num_of_days_to_add = get_interval($reps) - 1;
    return $local_time_dt->add(new DateInterval('P'.$num_of_days_to_add.'D'));
  }

}


// this functions inputs the reps value of the card
// and outputs next interval if correct button clicked)
function new_study_date_interval($reps, $last_rep) {
  $date_string = getLocalTime($_SESSION['gmt_int']);

  $local_time_dt = new DateTime($date_string);
  $local_time_dt_string = $local_time_dt->format('Y/m/d H:i:s');

  if ($reps == 0) {
    //add 10 minutes 
    return "+ 10 minutes";
  } else if ($reps == 1) {

    if ($last_rep > $reps) {
      $num_of_days_to_add = get_interval($last_rep);
      return "+ ".$num_of_days_to_add." days";
    } else {
      return "+ 10 minutes";
    }
    
  } else {
    $local_time_string = $local_time_dt->format('H:i:s');
    $num_of_days_to_add = get_interval($reps);
    return "+ ".$num_of_days_to_add." days";
  }
}

