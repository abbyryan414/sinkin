<?php

    session_start();
    $login_username = $_SESSION['username'];
    $current_path = $_SESSION['current_path'];

?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>add a deck</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" 
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
  crossorigin="anonymous"></script>
</head>
<body>

<h1>Add a deck:</h1>
<form method="post">
    <input name="deck_or_card_title" placeholder="deck name:" type="text">
    <button name="confirm-btn">confirm</button>
</form>
<form action="index.php">
  <button>return to home page</button>
</form>

</body>
</html>

<?php
if(array_key_exists('confirm-btn', $_POST)) { 

  require_once("phpFiles/db_handler.php");
    
  $deck_or_card_title=$_POST['deck_or_card_title'];
    
    
  require("phpFiles/functions_library.php");
  $local_time = getLocalTime($_SESSION['gmt_int']);
    

  $value = "SELECT* FROM users_cards WHERE username= '$login_username' AND deck_or_card_title = '$deck_or_card_title'";
  $result = $conn->query($value);
  //check for names including /
  if (preg_match("(/)","$deck_or_card_title")){
      echo "Deck name cannot include / ";
      }elseif (strlen($deck_or_card_title) > 0 && strlen(trim($deck_or_card_title)) == 0){
          //check for space
          echo "Deck name cannot be blank";
      }elseif (preg_match("(^[NULL]{0}$)","$deck_or_card_title")){
          //check for blank
          echo "Deck name cannot be blank";
      }elseif($result->num_rows > 0){
          //check for same deck
          echo "Deck name cannot be the same as an existing deck";
      }else{
      //insert data to table
      $sql = "INSERT INTO users_cards (username,currentpath,is_card,deck_or_card_title,card_info,created_date,study_date,reps)
      VALUES ('$login_username','$current_path',FALSE,'$deck_or_card_title','null','$local_time','2020-01-01 00:00:00','0')";
      
      if ($conn->query($sql) === TRUE) {
      echo "<br>". "New deck added";
      } else {
      echo "Error: " . $sql . "<br>" . $conn->error;

      }
      
  }
            
}

?>
