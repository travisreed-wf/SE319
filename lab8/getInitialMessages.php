<?php

  $con=mysqli_connect("mysql.cs.iastate.edu","u319all","024IjLaMj4dI","db319all");
  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  $username = $_GET['username'];
  $query = "SELECT Username FROM followers where FollowerName = '$username';";
  $result = mysqli_query($GLOBALS['con'], $query);
  $followersList = array();
  while($row = mysqli_fetch_array($result)) {
      $followersList[] = "'" . $row[0] . "'";
  }
  $followers = join(',',$followersList);  
  $messages = array();
  $query = "SELECT username, msg, posttime FROM message WHERE username in ($followers) ORDER BY posttime ASC;";
  $result = mysqli_query($con, $query);
  while($row = mysqli_fetch_array($result)) {
        $messages[] = $row;
        echo $row[0] . "     " . $row[1] . "      " . $row[2] . "<br>";
  }

?>
