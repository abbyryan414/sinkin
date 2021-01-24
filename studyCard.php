
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
<label for="">Card Title: </label>
<textarea name="card_title_area" id="card_title_area" cols="20" rows="3"></textarea>
<br><label for="">Card Info: </label>
<textarea name="card_info_area" id="card_info_area" cols="20" rows="3"></textarea>
<br><label for="">Reps: </label>
<textarea name="reps_area" id="reps_area" cols="20" rows="3"></textarea>
<br><label for="">Last Rep: </label>
<textarea name="last_rep_area" id="last_rep_area" cols="20" rows="3"></textarea>
<br><label for="">Created Date: </label>
<textarea name="created_date_area" id="created_date_area" cols="20" rows="3"></textarea>
<br><label for="">Study Date: </label>
<textarea name="study_date_area" id="study_date_area" cols="20" rows="3"></textarea><br>

<?php
session_start();
$_SESSION['deck_or_card_title'] = "stuff"; 
$_SESSION['card_info'] = "stuff";
$_SESSION['reps'];
$_SESSION['last_rep'];
$_SESSION['created_date'];
$_SESSION['study_date'];
?>

<script>
  function jsFunction(){
    deck_or_card_title = '<?php echo $_SESSION['deck_or_card_title']?>';
    card_info = '<?php echo $_SESSION['card_info']?>';
    reps = '<?php echo $_SESSION['reps']?>';
    last_rep = '<?php echo $_SESSION['last_rep']?>';
    created_date = '<?php echo $_SESSION['created_date']?>';
    study_date = '<?php echo $_SESSION['study_date']?>';

    document.getElementById('card_title_area').innerHTML = deck_or_card_title;
    document.getElementById('card_info_area').innerHTML = card_info;
    document.getElementById('reps_area').innerHTML = reps;
    document.getElementById('last_rep_area').innerHTML = last_rep;
    document.getElementById('created_date_area').innerHTML = created_date;
    document.getElementById('study_date_area').innerHTML = study_date;
  }
</script>

<?php 


//update local time
require("phpFiles/functions_library.php");
$local_time = getLocalTime($_SESSION['gmt_int']);
echo "Local Time: ".$local_time."<br>";


$username = $_SESSION['username'];
$current_path = $_SESSION['current_path'];

//this line of code is for javascript, cause js would be the $id, 
// and would throw error is $id is null, so we must give it some value
$id = "no id";

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
  $reps = 10000;
  $last_rep = 9999;

  while ($row = $result->fetch_assoc()) {
    if ($counter == 0) {
      $_SESSION['deck_or_card_title'] = $row['deck_or_card_title'];
      $_SESSION['card_info'] = $row['card_info'];
      $_SESSION['reps'] = $row['reps'];
      $_SESSION['last_rep'] = $row['last_rep'];
      $_SESSION['created_date'] = $row['created_date'];
      $_SESSION['study_date'] = $row['study_date'];

      echo "<br>Card Title: ".$_SESSION['deck_or_card_title']."<br>".
      "Card Info: ".$_SESSION['card_info']."<br>".
      "Reps(No. of times you viewed the card): ".$_SESSION['reps']."<br>".
      "Last_Rep: ".$_SESSION['last_rep']."<br>".
      "Created Date: ".$_SESSION['created_date']."<br>".
      "Study Date: ".$_SESSION['study_date']."<br>"."<br>";

      // echo "<br>Card Title: ".$row['deck_or_card_title']."<br>".
      // "Card Info: ".$row['card_info']."<br>".
      // "Reps(No. of times you viewed the card): ".$row['reps']."<br>".
      // "Last_Rep: ".$row['last_rep']."<br>".
      // "Created Date: ".$row['created_date']."<br>".
      // "Study Date: ".$row['study_date']."<br>"."<br>";

      // echo <<<EOT
      // <script type="text/JavaScript"> 
      //   present_info();
      //  </script>
      // EOT;
      echo '<script type="text/javascript">jsFunction();</script>';

      $reps = $row['reps'];
      $last_rep = $row['last_rep'];
      $id = $row['id'];
    }
    $counter = $counter - 1;
  }
} else {
  echo "result is null";

  
}



?>

<button id="wrong_btn" onclick="to_new_study_date_php('false')">Again :(</button>
<button style="white-space: pre-wrap;" id="correct_btn" onclick="to_new_study_date_php('true')">Got it :)</button>
<script>
 
  var id = "<?php echo $id?>";
  console.log(id);
  if (id == "no id") {
    document.getElementById('correct_btn').style.visibility = 'hidden';
    document.getElementById('wrong_btn').style.visibility = 'hidden';
  }

  function to_new_study_date_php(is_correct) {

    var username = "<?php echo $username?>";
    var id = "<?php echo $id?>";
    var reps = "<?php echo $reps?>";
    var last_rep = "<?php echo $last_rep?>";

    if ((id != "no id") && (reps != 10000))  {
      $.ajax({
        url: 'phpFiles/new_study_date.php',
        method: 'POST',
        dataType: 'text',
        data: {
          username: username,
          id: id,
          reps: reps,
          last_rep: last_rep,
          is_correct: is_correct
        }               
      }).done(function(returnedData){
          alert(returnedData);
          location.reload();
      })
    } else {
      console.log("don't have cards to study");
      document.getElementById('correct_btn').style.visibility = 'hidden';
      document.getElementById('wrong_btn').style.visibility = 'hidden';
    }
  }
  get_study_date_interval();
  //add next time interval label on button
  function get_study_date_interval() {

    var username = "<?php echo $username?>";
    var id = "<?php echo $id?>";
    var reps = "<?php echo $reps?>";
    var last_rep = "<?php echo $last_rep?>";

    if ((id != "no id") && (reps != 10000))  {
      $.ajax({
        url: 'phpFiles/get_study_date_interval.php',
        method: 'POST',
        dataType: 'text',
        data: {
          username: username,
          id: id,
          reps: reps,
          last_rep: last_rep
        }               
      }).done(function(returnedData){
        $("#wrong_btn").text("Again :( (< 1 minute)");
        $("#correct_btn").text("Got it :) (" + returnedData + ")");
        // alert(returnedData);
      })
    }
    //  else {
    //   console.log("don't have cards to study");
    //   document.getElementById('correct_btn').style.visibility = 'hidden';
    //   document.getElementById('wrong_btn').style.visibility = 'hidden';
    // }
  }
</script>




  
</body>
</html>


