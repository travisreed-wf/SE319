<?php 

session_start();
$username = $_SESSION["username"];
$message = $_POST["message"];

$time = time(); 
$date = date('Y-m-d H:i:s',$time);
echo $date;

function sendMessageToDB($message){
	$con=mysqli_connect("mysql.cs.iastate.edu","u319all","024IjLaMj4dI","db319all");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	mysqli_query($con,"INSERT INTO message (username, msg, posttime) VALUES ('$username', )");



	session_start();
	$_SESSION["username"] = $username;

	$url = 'http://' . $_SERVER['HTTP_HOST'];
	$url .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$url .= '/home.html';
	header('Location: ' . $url);  
}
?>

