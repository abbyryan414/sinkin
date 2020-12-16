<?php

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
?>