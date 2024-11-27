<?php

$servername = "localhost";
$username = "root"; //mysql username 
$password = ""; 
$dbname = "timberly";//database name

$con= new mysqli('localhost','root','','timberly');

 if($con->connect_error){
    die("Connection failed: " . $con->connect_error);
}

// if ($con){
//     echo "Connection Successful";
// }else{
//     echo "No Connection";
// }

?>