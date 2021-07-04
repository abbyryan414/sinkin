<?php

$servername = "localhost";
$uid = "root";
$dbpassword = "";
$dbname = "database";

// Create connection
$conn = new mysqli($servername, $uid, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>