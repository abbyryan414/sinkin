<html lang="en">
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
<button onclick="addDeck()">To AddCard</button>
<form action="" method="POST">
  <button type="submit" id="back_btn" name="back_btn">Back 1 Directory</button>
</form>



<?php

  session_start();

 

  $username = "Joseph";
  $current_path = $username . "/";
  // $_SESSION['current_path'] = "Joseph/";
  
  //receive current path from other files(eg: changeDirectory.php)
  if (isset($_SESSION['current_path'])) {
    $current_path = $_SESSION['current_path'];

  }

  $_SESSION['username'] = $username;
  $_SESSION['current_path'] = $current_path;

  echo "<br>Username: ".$username."<br>";
  echo "Current Path: ".$current_path."<br>";



  $servername = "localhost";
  $uid = "root";
  $password = "";
  $dbname = "database";

  // Create connection
  $conn = new mysqli($servername, $uid, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  //select all decks(Is_card value: 0) where username and current path matches
  $sql = "SELECT * FROM users_cards WHERE Username=? AND Currentpath=? AND Is_card='0'"; // SQL with parameters
  $stmt = $conn->prepare($sql); 
  $stmt->bind_param("ss", $username, $current_path);
  $stmt->execute();
  $result = $stmt->get_result(); // get the mysqli result
 

  if ($result->num_rows > 0) {
    echo "No of Results: ".($result->num_rows)."<br>";
    while ($row = $result->fetch_assoc()) {
      $deck_name = $row['Deck_or_card_title'];

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

//Hide back_btn if currentpath is root(eg: Marco/)
// and doesn't contain folders(eg:Marco/Deck1/)
var current_path = "<?php echo $current_path;?>";
var username = "<?php echo $username;?>" + "/";
if (username==current_path) {
  $("#back_btn").hide();
}





function toDictionary() {
  window.location.href = "dictionary.php";
}

function addDeck() {
  window.location.href = "addDeck.php";
  
}

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
      console.log(returnedData);
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

// This function inputs a string, and goes back 1 directory
// Eg: changes Marco/Deck1/Deck3/ to Marco/Deck1/
// MUST HAVE "/" in the end, eg: can't have Marco/Deck1
function back_one_dir($current_dir) {
  //remove the last character of the string
  $current_path_trimmed = substr($current_dir, 0, -1);

  //Reverse the order of the string
  $current_path_reversed = "";
  $len = strlen($current_path_trimmed);
  for($i=$len; $i > 0; $i--){
    $current_path_reversed .= $current_path_trimmed[$i-1];
  }

  //echo $current_path_reversed;

  //removes everything before(and including) the first "/"
  $out = substr(strstr($current_path_reversed, '/'), strlen('/'));
  
  
  //Reverse the order of the string
  $current_path_reversed = "";
  $len = strlen($out);
  for($i=$len; $i > 0; $i--){
    $current_path_reversed .= $out[$i-1];
  }
  $new_path = $current_path_reversed."/";
  return $new_path;
}


//if back btn is pressed
if(array_key_exists('back_btn', $_POST)) { 
  $_SESSION['current_path'] = back_one_dir($current_path);
  header("Refresh:0");
}


?>

  
</body>
</html>