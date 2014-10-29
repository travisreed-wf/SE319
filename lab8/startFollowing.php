<?php 
    session_start();
    $con=mysqli_connect("mysql.cs.iastate.edu","u319all","024IjLaMj4dI","db319all");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    
    $username = $_SESSION['username'];
    $followerName = $_SESSION['username'];
    $query = "INSERT INTO followers (username, followername) VALUES ('$username', '$followerName');";
    $result = mysqli_query($GLOBALS['con'], $query);




?>