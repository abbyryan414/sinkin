<?php 

session_start();


if (isset($_POST['current_path'])) {
  require("functions_library.php");
  $_SESSION['current_path'] = back_one_dir($_SESSION['current_path']);
  echo "job done";
}