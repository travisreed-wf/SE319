<?php 
    $con=mysqli_connect("mysql.cs.iastate.edu","u319all","024IjLaMj4dI","db319all");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    if (isset($_GET['username']) isset($_GET['followerName'])){
        $username = $_GET['username'];
        $followerName = $_GET['followerName'];
        $query = "INSERT INTO followers (username, followername) VALUES ($username, $followerName);";
        $result = mysqli_query($GLOBALS['con'], $query));    
    }
    else {
        echo "Missing data";
    }




?>