<?php 


$username = $_POST["username"];

print "above if";
if(check_database($username) == "false"){
	print "in if";
	register_database($username);	
}


function check_database($username){
	$con=mysqli_connect("mysql.cs.iastate.edu","u319all","024IjLaMj4dI","db319all");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$users = mysqli_query($con,"SELECT Username FROM usernames where username = '$username' LIMIT 0,1");
	$user = mysqli_fetch_array($users);
	echo $username;
	if($username != $user[0]){
		echo "falsifying";
		return "false";
	}
}

function register_database($username){
	$con=mysqli_connect("mysql.cs.iastate.edu","u319all","024IjLaMj4dI","db319all");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	echo "inserted";
	mysqli_query($con,"INSERT INTO usernames (username) VALUES ('$username')");
	mysqli_query($con,"INSERT INTO followers (username, followername) VALUES ('$username', '$username')");



	session_start();
	$_SESSION["username"] = $username;

	$url = 'http://' . $_SERVER['HTTP_HOST'];
	$url .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$url .= '/home.php';
	header('Location: ' . $url);  
}
?>

