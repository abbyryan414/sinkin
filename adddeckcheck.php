<?php
session_start();
$username =$_POST['username'];
$currentpath=$_POST['pathway'];
$Deck_or_card_title=$_POST['Deck_or_card_title'];

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
VALUES ('$username','$currentpath','FALSE','$Deck_or_card_title','NULL','how to do created date','NULL','NULL')";

if ($conn->query($sql) === TRUE) {
  echo "<br>". "New deck added";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

?>