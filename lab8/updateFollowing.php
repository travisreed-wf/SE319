<?php 

    $con=mysqli_connect("mysql.cs.iastate.edu","u319all","024IjLaMj4dI","db319all");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    if (isset($_GET['username'])){
        $username = $_GET['username'];
        $query = "SELECT Username FROM followers where FollowerName = '$username';";
        $result = mysqli_query($GLOBALS['con'], $query);
        $followers = array();
        while($row = mysqli_fetch_array($result)) {
            $followers[] = $row[0];
            echo $row[0];
            echo "<br>";
        }
        
    }
    else {
        echo "Missing data";
    }




?>