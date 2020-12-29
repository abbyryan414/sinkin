
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

//select all cards inside the deck, even its subdecks, 
//for example there's deck2 and deck2/deck2-1
//if user clicks study_card_btn in deck2, deck2/deck2-1 cards will
//also be shown

//select cards with 0-2 reps first
$sql = "SELECT * FROM users_cards WHERE username=? AND currentpath LIKE '%$current_path%' AND is_card='1' AND study_date < '$local_time' AND reps<'3'"; // SQL with parameters
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result

//array storing all the cards and info with 2-3 reps
$new_cards_array = array();

//this array is for storing all the information of ONE card, then
// add itself to the $new_cards_array, and empty itself
$array = array(); 

// If there's decks in current path, turn them to buttons
if ($result->num_rows > 0) {
  echo "No of Results: ".($result->num_rows)."<br>";
  
  while ($row = $result->fetch_assoc()) {
    //echo $row['deck_or_card_title'].", ".$row['card_info'].", ".$row['reps'].", ".$row['created_date'].", "."<br>";
    
    //first push the information for each individual card into $array
    array_push($array, $row['deck_or_card_title'], $row['card_info'], $row['reps'], $row['created_date']);
  
    //then pust $array into $new_cards_array, so that $new_cards_array will be an 3d array storing all cards infomation
    array_push($new_cards_array, $array);

     //empty array before pushing it to $new_cards_array again in the loop
     $array = [];
  }

  //randomize the order of the array
  shuffle($new_cards_array);

  //then rearrange the order, order by reps

  echo "new_cards_array:";
  print "<pre>";
  print_r($new_cards_array);
  print "</pre>";

} else {
  echo "new_cards_array:";
  echo "0 results";
}


//select cards which are not 0-2 reps 
$sql = "SELECT * FROM users_cards WHERE username=? AND currentpath LIKE '%$current_path%' AND is_card='1' AND study_date < '$local_time' AND reps>'2'"; // SQL with parameters
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result

//array storing all the cards and info with 3+ (not 0-2) reps
$cards_array = array();

//this array is for storing all the information of ONE card, then
// add itself to the $cards_array, and empty itself
$array = array(); 

// If there's decks in current path, turn them to buttons
if ($result->num_rows > 0) {
  echo "No of Results: ".($result->num_rows)."<br>";
  
  while ($row = $result->fetch_assoc()) {
    //echo $row['deck_or_card_title'].", ".$row['card_info'].", ".$row['reps'].", ".$row['created_date'].", "."<br>";
    
    //first push the information for each individual card into $array
    array_push($array, $row['deck_or_card_title'], $row['card_info'], $row['reps'], $row['created_date']);
  
    //then pust $array into $cards_array, so that $cards_array will be an 3d array storing all cards infomation
    array_push($cards_array, $array);

     //empty array before pushing it to $cards_array again in the loop
     $array = [];
  }

  //randomize the order of the array
  shuffle($cards_array);

  //then rearrange the order, order by reps

  echo "cards_array:<br>";
  print "<pre>";
  print_r($cards_array);
  print "</pre>";

} else {
  echo "cards_array:<br>";
  echo "0 results";
}


$result_array = array_merge($new_cards_array, $cards_array);

echo "<br>result_array:";
print "<pre>";
print_r($result_array);
print "</pre>";













?>


  
</body>
</html>


