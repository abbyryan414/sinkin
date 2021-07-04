<?php

session_start();
require("functions_library.php");
require("db_handler.php");

if (isset($_POST['current_path'])) {
  $current_path = $_POST['current_path'];
  $current_path_minus_one = back_one_dir($current_path);
  $username = $_SESSION['username'] ;

  //gets the deck name
    $deck_to_delete = getLastDir($current_path);
  
    $sql = "DELETE FROM users_cards WHERE username='$username' AND (deck_or_card_title='$deck_to_delete' OR currentpath LIKE '$current_path%')"; // SQL with parameters
    if (mysqli_query($conn, $sql)) {
      echo "Record deleted successfully";
      $_SESSION['current_path'] = back_one_dir($current_path);
    } else {
      echo "Error deleting record: " . mysqli_error($conn);
    }
   
}