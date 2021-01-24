<?php
  session_start();
  
  if(isset($_POST['username'])) { 
    $username = $_POST['username'];
    $id = $_POST['id'];
    $reps = $_POST['reps'];
    $last_rep = $_POST['last_rep'];

    //update local time
    require("functions_library.php");
    $local_time = getLocalTime($_SESSION['gmt_int']);
    //echo "Local Time: ".$local_time."<br>";


    //should return true or false, NOT boolean but in string form!
    $is_correct = $_POST['is_correct'];
    //echo $is_correct;

    if ($is_correct == "true") {
      echo "correct";
      //If first try
      if ($reps == 0) {
        //Adds 2(skips rep 1) if correct on first try
        $new_reps = $reps + 2;

        //set the rep to last_rep if possible (if the user forgot a word that's been there for a long time)
        //if not possible, then just add one
      } else if ($reps == 1) {
        if ($last_rep != 0) {
          $new_reps = $last_rep + 1;
          $last_rep = 10000;
        } else {
          $new_reps = $reps + 1;
        }
        $reps = $new_reps - 1;
        
      } else {
        $new_reps = $reps + 1;
      }


    } else if ($is_correct == "false") {
      echo "false";
      //Firstly, the last rep value will be deducted by 3, that's the rep the 
      //user will continue on with the card if he gets it right afterwards
      $last_rep = $reps - 3;

      //the new_reps will be set to rep 1, so it'll be seen ASAP
      $new_reps = 1;
      
      // if last rep value lower than one, for example if the rep of the card is 2
      // and when you deduct by 3 it's -1, then set last rep value to 0
      if ($last_rep <= 0) {
        $last_rep = 0;
      }
      //indicate that he got the card wrong, so card'll be shown after 1 minute
      $reps = -1;
    }
    //get new study_date
    $new_study_date = new_study_date($reps);
    echo $reps;
    $new_study_date_string = $new_study_date->format('Y-m-d H:i:s');
    echo "<br>New Study Date: ".$new_study_date_string;

    require("db_handler.php");
    

    $sql = "UPDATE users_cards SET last_rep = '$last_rep', study_date='$new_study_date_string', reps='$new_reps' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $conn->error;
    }
  }


?>