<?php 
    $con=mysqli_connect("mysql.cs.iastate.edu","u319all","024IjLaMj4dI","db319all");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    if (isset($_GET['username'])){
        $username = $_GET['username'];
        $query = "SELECT username FROM usernames;";
        $result = mysqli_query($GLOBALS['con'], $query);
        $users = array();
        while($row = mysqli_fetch_array($result)) {
            $users[] = $row[0];
            $followers = getFollowers($row[0], $username);
            if ($followers != -1){
                $followerCount = count($followers);
                echo "<tr><td>" . $row[0] . "</td>";
                echo "<td>" . $followerCount . "</td>";
                echo "<td><input type='button' class='startFollowing' value='+'></td>";
                echo "</tr>";
            }     
        }
    }
    else {
        echo "Missing data";
    }

    function getFollowers($username, $loggedInUser){
        $query = "SELECT Followername FROM followers where username = '$username';";
        $result = mysqli_query($GLOBALS['con'], $query);
        $followers = array();
        while($row = mysqli_fetch_array($result)) {
            $followers[] = $row[0];
            if (strcasecmp($row[0], $loggedInUser) == 0){
                return -1;
            }
        }
        return $followers;
    }

?>