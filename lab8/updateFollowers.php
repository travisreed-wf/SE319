<?php 

    $con=mysqli_connect("mysql.cs.iastate.edu","u319all","024IjLaMj4dI","db319all");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    if (isset($_GET['username'])){
        $username = $_GET['username'];
        $query = "SELECT Followername FROM followers where username = '$username';"
        $result = mysqli_query($GLOBALS['con'], $query);
        $result_array = (mysqli_fetch_array($result));
        echo $result_array
    }
    else {
        echo "Missing data";
    }




?>