
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

$sql = "SELECT * FROM users_cards WHERE username=? AND currentpath=? AND is_card='1' AND study_date < '$local_time'"; // SQL with parameters
$stmt = $conn->prepare($sql); 
$stmt->bind_param("ss", $username, $current_path);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result

// If there's decks in current path, turn them to buttons
if ($result->num_rows > 0) {
  echo "No of Results: ".($result->num_rows)."<br>";
  while ($row = $result->fetch_assoc()) {
    echo $row['deck_or_card_title'].", ".$row['card_info'].", ".$row['reps'].", ".$row['created_date'].", "."<br>";
  }
} else {
  echo "0 results";
}

?>
  
</body>
</html>


