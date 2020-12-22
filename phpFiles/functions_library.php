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
}
