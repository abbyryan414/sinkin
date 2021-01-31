
<?php

session_start();
$gen_card_id = (int)$_SESSION['gen_card_id'];
//Get username and currentpath(before clicking addcard.php)
$login_username = $_SESSION['username'];
$current_path = $_SESSION['current_path'];
echo $gen_card_id;

// echo "login_username: ".$login_username."<br>";
// echo "current_path: ".$current_path."<br>";

//import function library 
require_once("phpFiles/functions_library.php");





require_once("phpFiles/db_handler.php");

$sql = "SELECT * FROM users_cards WHERE username= '$login_username' AND id = $gen_card_id";
$result = $conn->query($sql);
$row=$result->fetch_assoc();
echo $row['deck_or_card_title'];

?>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>edit this card</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" 
integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
crossorigin="anonymous"></script>
</head>
<body>

<h1>Edit this card:</h1>
<form method="post">
    <textarea placeholder="Card Name: " name="deck_or_card_title_area" id="deck_or_card_title_area" cols="30" rows="10"><?php echo $row['deck_or_card_title'] ?></textarea> 
    <textarea placeholder="Card Info: " name="card_info_area" id="card_info_area" cols="30" rows="10"><?php echo $row['card_info'] ?></textarea>
    
    
    
   
</form>
<form action="index.php">
  <button>return to home page</button>
</form>
<button onclick="confirm()">update card</button>
<button onclick="deletec()">delete card</button>
<script>
function confirm() {
  var deck_or_card_title = document.getElementById('deck_or_card_title_area').value;
  var card_info = document.getElementById('card_info_area').value;
  
  
  $.ajax({
    url: 'phpFiles/ajax_edit_card.php',
    method: 'POST',
    dataType: 'text',
    data: {
      deck_or_card_title: deck_or_card_title,
      card_info: card_info
    }               
  }).done(function(returnedData){
      alert(returnedData);
      location.reload();
  })
}
function deletec() {
  $.ajax({
    url: 'phpFiles/ajax_delete_card.php',
             
  }).done(function(returnedData){
      alert(returnedData);
      window.location.href = "index.php";
  })
}
</script>
</body>
</html>


