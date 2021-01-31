<?php


require("functions_library.php");
require("db_handler.php");
session_start();

$login_username = $_SESSION['username'];
$gen_card_id = (int)$_SESSION['gen_card_id'];


          

              
      //delete table data
      $sql = "DELETE FROM users_cards WHERE username = '$login_username' AND id=$gen_card_id";
              
      if ($conn->query($sql) === TRUE) {
      echo "card deleted";
      //header("Location:index.php");
      } else {
        echo "hi";
      echo "Error: " . $sql . "<br>" . $conn->error;
      }
      //header("Refresh:0");

    

?>