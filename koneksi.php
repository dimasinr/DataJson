<?php
$servername = "localhost";
$username = "ciel";
$password = "some_pass";
$dbname = "webcsv";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}