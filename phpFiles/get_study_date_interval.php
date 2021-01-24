<?php

session_start();
  
if(isset($_POST['username'])) { 
  $username = $_POST['username'];
  $id = $_POST['id'];
  $reps = $_POST['reps'];
  $last_rep = $_POST['last_rep'];

  require("functions_library.php");
  $new_study_date_interval = new_study_date_interval($reps, $last_rep);
  echo $new_study_date_interval;


}
