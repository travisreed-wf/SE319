<?php 

session_start();
$username = $_SESSION["username"];
$message = $_GET["message"];

$time = time(); 
$date = date('Y-m-d H:i:s',$time);


$con=mysqli_connect("mysql.cs.iastate.edu","u319all","024IjLaMj4dI","db319all");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mysqli_query($con,"INSERT INTO message (username, msg, posttime) VALUES ('$username', '$message', '$date')");
//mysqli_query($con,"INSERT INTO followers (username, followername) VALUES ('$username', '$username')");



?>

