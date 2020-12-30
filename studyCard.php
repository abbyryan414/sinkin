
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Study Cards</title>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" 
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
  crossorigin="anonymous"></script>

</head>
<body>


<?php 

session_start();


//update local time
require("phpFiles/functions_library.php");
$local_time = getLocalTime($_SESSION['gmt_int']);
echo "Local Time: ".$local_time."<br>";


$username = $_SESSION['username'];
$current_path = $_SESSION['current_path'];

echo "Username: ".$username.", ";
echo "Current Path: ".$current_path."<br>";


require_once("phpFiles/db_handler.php");
//select all cards in the deck the user is currently in

function query_and_fetch_result($conn, $sql, $username) {
  $stmt = $conn->prepare($sql); 
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result(); // get the mysqli result
  return $result;
}

//select cards inside the deck, even its subdecks, 
//for example there's deck2 and deck2/deck2-1
//if user clicks study_card_btn in deck2, deck2/deck2-1 cards will
//also be shown

/*the cards will be shown one by one, in this order:
1. 1 reps (cards that were wrong on first try) due cards
2. 2 reps (cards that were correct 1 time) due cards
3. 0 reps due cards
4. All due cards
5. 1 reps not due cards
6. 2 reps not due cards

The following code chooses the suitable sql statement
*/


//check if there are 1 rep cards (cards that were wrong on first try) that are due 
$sql = "SELECT * FROM users_cards WHERE username=? AND currentpath LIKE '$current_path%' AND is_card='1' AND study_date < '$local_time' AND reps='1'"; // SQL with parameters
$result = query_and_fetch_result($conn, $sql, $username);

if ($result->num_rows <= 0) {
  //check if there are 2 reps cards (cards that were correct 1 time) that are due 
  $sql = "SELECT * FROM users_cards WHERE username=? AND currentpath LIKE '$current_path%' AND is_card='1' AND study_date < '$local_time' AND reps='2'"; // SQL with parameters
  $result = query_and_fetch_result($conn, $sql, $username);

  if ($result->num_rows <= 0) {
    //check if there are 0 reps cards (totally new cards) that are due 
    $sql = "SELECT * FROM users_cards WHERE username=? AND currentpath LIKE '$current_path%' AND is_card='1' AND study_date < '$local_time' AND reps='0'"; // SQL with parameters
    $result = query_and_fetch_result($conn, $sql, $username);

    if ($result->num_rows <= 0) {
      //check if there are any cards that are due 
      $sql = "SELECT * FROM users_cards WHERE username=? AND currentpath LIKE '$current_path%' AND is_card='1' AND study_date < '$local_time'"; // SQL with parameters
      $result = query_and_fetch_result($conn, $sql, $username);

      if ($result->num_rows <= 0) {
        //check if there are any 1 rep cards that are NOT YET due
        $sql = "SELECT * FROM users_cards WHERE username=? AND currentpath LIKE '$current_path%' AND is_card='1' AND reps='1'"; // SQL with parameters
        $result = query_and_fetch_result($conn, $sql, $username);

        if ($result->num_rows <= 0) {
          //check if there are any 2 rep cards that are NOT YET due
          $sql = "SELECT * FROM users_cards WHERE username=? AND currentpath LIKE '$current_path%' AND is_card='1' AND reps='2'"; // SQL with parameters
          $result = query_and_fetch_result($conn, $sql, $username);

          if ($result->num_rows <= 0) {
            echo "Congrats! No more cards to study for today. Time to chill :)";
          }
        }
      }
    }
  }
}

if (!is_null($result)) {
  $num_of_rows = $result->num_rows;
  $random_int = rand(1,$num_of_rows);
  $counter = $num_of_rows - $random_int;
  $rep = 10000;

  while ($row = $result->fetch_assoc()) {
    if ($counter == 0) {
      echo $row['deck_or_card_title'].", ".$row['card_info'].", ".$row['reps'].", ".$row['created_date'].", ".$row['study_date'].", "."<br>";
      $rep = $row['reps'];
      $_SESSION['reps'] = $rep;
      $_SESSION['id'] = $row['id'];
    }
    $counter = $counter - 1;
  }
} else {
  echo "result is null";
}



?>

<form action="#" method="POST">
  <button name="correct-btn" type="submit">
    <?php
      echo "Rep: ".$rep;
      $interval = get_interval($rep);
      echo "<br>Interval: ".$interval."<br>";
      //echo "<br>LT: ".$local_time;

    
      $local_time_string = strval($local_time);

      echo "<br>Local Time: $local_time_string";
      $new_date = new_study_date($local_time_string, $rep);
      $_SESSION['new_date'] = $new_date->format('Y-m-d H:i:s');
      echo "<br>New Study Date: ".$new_date->format('Y-m-d H:i:s');
    ?>
  </button>
  <?php
    if(isset($_POST['correct-btn'])) { 
      $username = $_SESSION['username'];
      $new_date = $_SESSION['new_date'];
      $id = $_SESSION['id'];
      $new_reps = $_SESSION['reps'] + 1;

      echo "<br>".$new_date;
      echo "<br>".$new_reps;
      echo "<br>".$id;
      echo "<br>".$username;

      $sql = "UPDATE users_cards SET study_date='$new_date', reps='$new_reps' WHERE id='$id'";

      if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
      } else {
        echo "Error updating record: " . $conn->error;
      }


      // //echo "<br>New Study Date: ".$new_date->format('Y-m-d H:i:s');
      // $sql = "UPDATE users_cards SET study_date='$new_date' AND reps='$new_reps' WHERE username=? AND id=?";

      // $stmt = $conn->prepare($sql); 
      // $stmt->bind_param("si", $username, $id);
      // $stmt->execute();
      // echo $stmt->affected_rows;
    }


  ?>
</form>



  
</body>
</html>


