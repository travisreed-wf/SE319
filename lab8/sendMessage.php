<?php 


$message = $_POST["message"];

print "above if";
if(check_database($username) == "false"){
	print "in if";
	register_database($username);	
}else{
	$url = 'http://' . $_SERVER['HTTP_HOST'];
	$url .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$url .= '/home.html';
	header('Location: ' . $url); 
}

function sendMessageToDB($message){
	$con=mysqli_connect("mysql.cs.iastate.edu","u319all","024IjLaMj4dI","db319all");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	mysqli_query($con,"INSERT INTO message (username, msg, posttime) VALUES ('$username', )");
	mysqli_query($con,"INSERT INTO followers (username, followername) VALUES ('$username', '$username')");



	session_start();
	$_SESSION["username"] = $username;

	$url = 'http://' . $_SERVER['HTTP_HOST'];
	$url .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$url .= '/home.html';
	header('Location: ' . $url);  
}
?>

