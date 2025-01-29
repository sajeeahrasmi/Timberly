<?php
$servername = "localhost";
$username = "root"; 
$password = "new_password"; 
$dbname = "newtimberly";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

