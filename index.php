<html lang="en"> testing
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>

  <!-- JQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" 
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
  crossorigin="anonymous"></script>
</head>
<body>

<h1 id="welcome-msg"></h1>
<button onclick="toDictionary()">To Dictionary</button>
<button onclick="addDeck()">To AddDeck</button>
<button onclick="studyCard()" id="study_card_btn">Study Cards in this Deck</button>
<form action="" method="POST">
  <button type="submit" id="back_btn" name="back_btn">Back 1 Directory</button>
  <button type="submit" id="delete_deck_btn" name="delete_deck_btn">Delete Deck</button>
  <button type="submit" id="add_card_btn" name="add_card_btn">To Add Card</button>
</form>


<?php

  session_start();



  //set default username 
  $username = "ryan1";
  $current_path = $username . "/";
  
  //receive current path from other files(eg: changeDirectory.php)
  if (isset($_SESSION['current_path'])) {
    $current_path = $_SESSION['current_path'];

  }

 
  $_SESSION['username'] = $username;
  $_SESSION['current_path'] = $current_path;



  echo "<br>Username: ".$username."<br>";
  echo "Current Path: ".$current_path."<br>";

  require_once("phpFiles/db_handler.php");
  


  //select all decks(Is_card value: 0) where username and current path matches
  $sql = "SELECT * FROM users_cards WHERE username=? AND currentpath=? AND is_card='0'"; // SQL with parameters
  $stmt = $conn->prepare($sql); 
  $stmt->bind_param("ss", $username, $current_path);
  $stmt->execute();
  $result = $stmt->get_result(); // get the mysqli result
 
  // If there's decks in current path, turn them to buttons
  if ($result->num_rows > 0) {
    echo "No of Results: ".($result->num_rows)."<br>";
    while ($row = $result->fetch_assoc()) {
      $deck_name = $row['deck_or_card_title'];

      //auto generate button for decks
      echo <<<EOT
      <button onclick='deck_clicked("$deck_name")'>$deck_name</button>
      EOT;
    }
  } else {
    echo "0 results";
  }


?>

<script>

//The function returns the time zone offset, 
//for example HK is GMT +8,
// so it'll return 8
function get_time_zone_offset( ) {
  var current_date = new Date();
  return parseInt(-current_date.getTimezoneOffset() / 60);
}

update_time();

function update_time() {
  var time_zone_offset = get_time_zone_offset();
  
  //send time_zone_offset to php, do stuff so that local time 
  //can be accessed with $_SESSION['local_time] in any page
  $.ajax({
    url: 'phpFiles/get_time_zone.php',
    method: 'POST',
    dataType: 'text',
    data: {
        time_zone_offset: time_zone_offset
    }               
  }).done(function(returnedData){
      console.log(returnedData);
  })
}



// Hide back_btn if currentpath is root(eg: Marco/)
// and doesn't contain folders(eg:Marco/Deck1/)
var current_path = "<?php echo $current_path;?>";
var username = "<?php echo $username;?>" + "/";
if (username==current_path) {
  $("#back_btn").hide();
  $("#delete_deck_btn").hide();
  $("#add_card_btn").hide();

}


//Go to respective pages if respective buttons are clicked
function toDictionary() {
  window.location.href = "dictionary.php";
}

function addDeck() {
  window.location.href = "adddeck.php";
  
}

function addCard() {
  window.location.href = "addcard.php";
  
}

function studyCard() {
  window.location.href = "studyCard.php";
}

// Go to changeDirectory.php to change the current path if deck button is clicked
// and it'll refresh the page to search for decks in new path
function deck_clicked(deck_name) {
  if (deck_name === undefined) {
    deck_name = "default deck name";
  }

  $.ajax({
    url: 'phpFiles/changeDirectory.php',
    method: 'POST',
    dataType: 'text',
    data: {
        deck_name: deck_name,
        current_path: "<?php echo $current_path?>"
    }               
  }).done(function(returnedData){
      console.log(returnedData);// console print returnedData(php echoed stuff)
      location.reload();
      //window.location.href="phpFiles/editYTLink.php"; 
  })
}

// Gets username from php and add welcome user text to h1
  var username = "<?php echo $username?>";
  var welcome_msg = "Welcome " + username + "!";
  $('#welcome-msg').text(welcome_msg);



</script>

<?php

require("phpFiles/functions_library.php");


//if add_card_btn is pressed, go back one directory, and refresh page
if(array_key_exists('add_card_btn', $_POST)) { 
  session_start();
  $_SESSION['selected_deck'] = getLastDir($current_path);
  header("Location:addcard.php");
}


//if back btn is pressed, go back one directory, and refresh page
if(array_key_exists('back_btn', $_POST)) { 
  $_SESSION['current_path'] = back_one_dir($current_path);
  header("Refresh:0");
}


//if delete_deck btn is pressed, go back one directory
// (eg: Marco/Deck1/ -> Marco/)
// Also changes the current_path global variable
if(array_key_exists('delete_deck_btn', $_POST)) {
  $current_path_minus_one = back_one_dir($current_path);

//gets the deck name
  $deck_to_delete = getLastDir($current_path);
  
  $sql = "DELETE FROM users_cards WHERE username='$username' AND (deck_or_card_title='$deck_to_delete' OR currentpath LIKE '$current_path%')"; // SQL with parameters
  if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
    echo $current_path_minus_one;
    echo $current_path;
    $_SESSION['current_path'] = back_one_dir($current_path);
    header("Refresh:0");
  } else {
    echo "Error deleting record: " . mysqli_error($conn);
  }
   
}

?>

  
</body>
</html>