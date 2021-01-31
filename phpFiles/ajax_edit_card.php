<?php


require("functions_library.php");
require("db_handler.php");
session_start();

$login_username = $_SESSION['username'];
$gen_card_id = (int)$_SESSION['gen_card_id'];


          
$deck_or_card_title = $_POST['deck_or_card_title'];
$card_info = $_POST['card_info'];



        
//check for names including /
if (preg_match("(/)","$deck_or_card_title")){
            
    echo "Card name cannot include / ";
                
    }elseif (strlen($deck_or_card_title) > 0 && strlen(trim($deck_or_card_title)) == 0){
        //check for space of name
        echo "Card name cannot be blank";
    }elseif (preg_match("(^[NULL]{0}$)","$deck_or_card_title")){
        //check for blank of name
        echo "Card name cannot be blank";
    }else{
             
              
      //update table data
      $sql = "UPDATE users_cards SET deck_or_card_title='$deck_or_card_title', card_info='$card_info' WHERE username = '$login_username' AND id=$gen_card_id";
              
      if ($conn->query($sql) === TRUE) {
      echo "card updated";
      //header("Location:index.php");
      } else {
        echo "hi";
      echo "Error: " . $sql . "<br>" . $conn->error;
      }
      //header("Refresh:0");

    } 

?>