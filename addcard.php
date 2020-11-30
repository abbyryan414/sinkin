<?php
    $username =$_POST['username'];
    $currentpath=$_POST['pathway'];
    if (isset($_POST['cardtitle'])) {
        $cardtitle =$_POST['cardtitle'];
    } else {
        $cardtitle = "";
    }
    if (isset($_POST['cardinfo'])) {
        $cardinfo =$_POST['cardinfo'];
    } else {
        $cardinfo = "";
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add a card</title>
</head>
<body>
    <h1>Add a card:</h1>
    <form method="post" action="adddeckcheck.php">
        <input name="Deck_or_card_title"placeholder="card name:" value="<?php echo $cardtitle ?>" type="text">
        <input name="cardinfo"placeholder="card info:" value="<?php echo $cardinfo ?>"type="text">
        <select name="deck">
                    
                
                    <option value="male">male</option>
					<option value="female">female</option>
					<option value="other">other</option>
				</select>
        <button>confirm<button>
    </form>
    
</body>
</html>
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database";

// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//insert data to table
$sql = "INSERT INTO users_cards (Username,Currentpath,Is_card,Deck_or_card_title,Card_info,Created_date,Study_date,Reps)
VALUES ('$username','$currentpath/$deck','TRUE','$Deck_or_card_title','$cardinfo','how to do created date','how to do study date',0)";


?>