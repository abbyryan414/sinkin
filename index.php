<html lang="en"> 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <link rel="stylesheet" href="css_files/index.css">
  <!-- JQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" 
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
  crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous"> -->
</head>
<body>
<div class="container">
  <img id="logo" src="images/logo.png" alt="">
  <h1 id="welcome-msg"></h1>
  <!-- <img id="mountain_png" src="images/mountain_png.png" alt=""> -->
  <img id="mountain_png" src="images/melody_tree.PNG" alt="">
  <h4 id="current_path_label">Current Path: blahblahblah</h4>
</div>

<div class="container2">

<!-- <div class="button_container"> -->

  <div class="upper_btn_container">
    <button class="button" onclick="toDictionary()">
      <img class="icons" src="images/add_card.png" alt="">
      <h4 class="button_labels">Add Card</h4>
    </button>
    <button class="button" onclick="addDeck()">
      <img class="icons" src="images/add_deck.png" alt="">
      <h4 class="button_labels">Add Deck</h4>
    </button>
  </div>
  <div class="lower_btn_container">
    <button class="button" onclick="studyCard()" id="study_card_btn">
      <img class="icons" src="images/study_cards.png" alt="">
      <h4 class="button_labels">Study Cards in this Deck</h4>
    </button>
    <button class="button" onclick="search()">
      <img class="icons" src="images/search.png" alt="">
      <h4 class="button_labels">Search For Cards</h4>
    </button>
  </div>
  
  

  <button class="button" onclick="back_btn_clicked()" id="back_btn" name="back_btn"><i id="back_icon" class="fas fa-backward"></i> Back</button>
  
  <!-- <button class="delete_deck_btn" onclick="delete_btn_clicked()" id="delete_deck_btn" name="delete_deck_btn"></button> -->
  <button class="delete_deck_btn" onclick="delete_btn_clicked()" id="delete_deck_btn" name="delete_deck_btn"><img src="images/delete.png" alt=""></button>
  
  <form class="button_form" action="" method="POST">
    
    <button type="submit" id="logout_btn" name="logout_btn">Log out</button>
  </form>


<!-- </div> -->

<div id="echo_div">

<?php

  session_start();

  function getLastDir($current_dir) {
    //remove the last character of the string
    $current_path_trimmed = substr($current_dir, 0, -1);
    
    //Reverse the order of the string
    $current_path_reversed = "";
    $len = strlen($current_path_trimmed);
    for($i=$len; $i > 0; $i--){
      $current_path_reversed .= $current_path_trimmed[$i-1];
    }
    $out = strtok($current_path_reversed, '/');
    //Reverse the order of the string
    $current_path_reversed = "";
    $len = strlen($out);
    for($i=$len; $i > 0; $i--){
      $current_path_reversed .= $out[$i-1];
    }
    return $current_path_reversed;
  }
  

  //set default username 
  //$username = "ryan1";
  //$current_path = $username . "/";
  
  //receive current path from other files(eg: changeDirectory.php)
  if (isset($_SESSION['current_path'])) {
    $current_path = $_SESSION['current_path'];

  }
  $pooth;
  $username = $_SESSION['username'] ;
  $current_path = $_SESSION['current_path'] ;

  if (isset($username) == false ) {
    header("Location:login.php");

  }
  if (substr_count($current_path,"/")>1){
    $pooth = getLastDir($current_path);

  }
  else if (substr_count($current_path,"/")==1){
    $pooth = "Home";
  }



  echo "
  <script>
      document.getElementById('current_path_label').innerHTML ='Current Path: $pooth';
  </script>";

  require_once("phpFiles/db_handler.php");
  


  //select all decks(Is_card value: 0) where username and current path matches
  $sql = "SELECT * FROM users_cards WHERE username=? AND currentpath=? AND is_card='0'"; // SQL with parameters
  $stmt = $conn->prepare($sql); 
  $stmt->bind_param("ss", $username, $current_path);
  $stmt->execute();
  $result = $stmt->get_result(); // get the mysqli result
 
  // If there's decks in current path, turn them to buttons
  if ($result->num_rows > 0) {
    echo "No of Decks: ".($result->num_rows)."<br>";
    while ($row = $result->fetch_assoc()) {
      $deck_name = $row['deck_or_card_title'];

      //auto generate button for decks
      echo <<<EOT
      <button class="decks" onclick='deck_clicked("$deck_name")'><img id="deck_png" src="images/deck.png" alt=""><h1 class="deck_label">$deck_name</h1></button>
      EOT;
    }
  } else {
    echo "0 results";
  }


?>

</div>


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
function search() {
  window.location.href = "search.php";
}

function back_btn_clicked() {
  $.ajax({
    url: 'phpFiles/back_btn_clicked.php',
    method: 'POST',
    dataType: 'text',
    data: {
      current_path: "<?php echo $_SESSION['current_path']?>"
    }               
  }).done(function(returnedData){
      console.log(returnedData);// console print returnedData(php echoed stuff)
      location.reload();
      //window.location.href="phpFiles/editYTLink.php"; 
  })
}

function delete_btn_clicked() {
  $.ajax({
    url: 'phpFiles/delete_btn_clicked.php',
    method: 'POST',
    dataType: 'text',
    data: {
      current_path: "<?php echo $_SESSION['current_path']?>"
    }               
  }).done(function(returnedData){
      alert(returnedData);
      location.reload();
  })
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


//if logout-btn pressed, set everything as null and direct to login.php
if(array_key_exists('logout_btn', $_POST)) { 
  $username = null;
  $current_path = null; 
  $_SESSION['username'] = null;
  $_SESSION['current_path'] = null;
  //header("Location:login.php");
  echo '<script>parent.window.location.reload(true);</script>';
}


//if delete_deck btn is pressed, go back one directory
// (eg: Marco/Deck1/ -> Marco/)
// Also changes the current_path global variable
// if(array_key_exists('delete_deck_btn', $_POST)) {
//   $current_path_minus_one = back_one_dir($current_path);



//  //gets the deck name
//   $deck_to_delete = getLastDir($current_path);
  
//   $sql = "DELETE FROM users_cards WHERE username='$username' AND (deck_or_card_title='$deck_to_delete' OR currentpath LIKE '$current_path%')"; // SQL with parameters
//   if (mysqli_query($conn, $sql)) {
//     echo "Record deleted successfully";
//     echo $current_path_minus_one;
//     echo $current_path;
//     $_SESSION['current_path'] = back_one_dir($current_path);
//     header("Refresh:0");
//   } else {
//     echo "Error deleting record: " . mysqli_error($conn);
//   }
   
// }


?>

<!-- This div tag closes the div with class "container2" -->
</div>

</body>
</html>