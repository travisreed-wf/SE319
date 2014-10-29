<?php 

    $con=mysqli_connect("mysql.cs.iastate.edu","u319all","024IjLaMj4dI","db319all");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    session_start();
    $username = $_SESSION['username'];
    $query = "SELECT Followername FROM followers where username = '$username';";
    $result = mysqli_query($GLOBALS['con'], $query);
    $followers = array();
    while($row = mysqli_fetch_array($result)) {
        $followers[] = $row[0];
        echo $row[0];
        echo "<br>";
    }
        




?>