<?php

session_start();

// receive the name of the deck selected and current_path 
// from index.php
if (isset($_POST['deck_name'])) {
  $current_path = $_POST['current_path'];
  $deck_name = $_POST['deck_name'];
  
  $new_path = $current_path.$deck_name."/";

  //set new path as current_path
  $_SESSION['current_path'] = $new_path;
  echo $new_path;

}

