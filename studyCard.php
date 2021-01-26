
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

$card_title = "";
$card_info = "";
$reps2 = "";
$last_rep2 = "";
$created_date = "";
$study_date = "";

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

      $card_title = $row['deck_or_card_title'];
      $card_info = $row['card_info'];
      $reps2 = $row['reps'];
      $last_rep2 = $row['last_rep'];
      $created_date = $row['created_date'];
      $study_date = $row['study_date'];
      echo "<br>Card Title: ".$card_title."<br>".
      "Card Info: ".$card_info."<br>".
      "Reps(No. of times you viewed the card): ".$reps2."<br>".
      "Last_Rep: ".$last_rep2."<br>".
      "Created Date: ".$created_date."<br>".
      "Study Date: ".$study_date."<br>"."<br>";

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
<br>
<label for="">Card Title: </label>
<textarea name="card_title_area" id="card_title_area" cols="20" rows="3">
<?php echo $card_title;?>
</textarea>
<br><label for="">Card Info: </label>
<textarea name="card_info_area" id="card_info_area" cols="20" rows="3">
<?php echo $card_info;?>
</textarea>
<br><label for="">Reps: </label>
<textarea name="reps_area" id="reps_area" cols="20" rows="3">
<?php echo $reps2;?>
</textarea>
<br><label for="">Last Rep: </label>
<textarea name="last_rep_area" id="last_rep_area" cols="20" rows="3">
<?php echo $last_rep2;?>
</textarea>
<br><label for="">Created Date: </label>
<textarea name="created_date_area" id="created_date_area" cols="20" rows="3">
<?php echo $created_date;?>
</textarea>
<br><label for="">Study Date: </label>
<textarea name="study_date_area" id="study_date_area" cols="20" rows="3">
<?php echo $study_date;?>
</textarea>

<br>



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


