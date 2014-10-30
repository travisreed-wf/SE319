<?php

$time = time(); 
$date = date('Y-m-d H:i:s', $time);
$con=mysqli_connect("mysql.cs.iastate.edu","u319all","024IjLaMj4dI","db319all");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// session_start();
while (1) {
  sleep(10);
  $messages = array();
  $followers = array();
  $username = $_GET['username'];
  $query = "SELECT Username FROM followers where FollowerName = '$username';";
  $result = mysqli_query($GLOBALS['con'], $query);
  $followersList = array();
  while($row = mysqli_fetch_array($result)) {
      $followersList[] = "'" . $row[0] . "'";
  }
  $followers = join(',',$followersList);  
  $query = "SELECT username, msg, posttime FROM message WHERE posttime > '$date' and username in ($followers) ORDER BY posttime ASC;";
  $time = time(); 
  $date = date('Y-m-d H:i:s', $time);
  $result = mysqli_query($con, $query);
  while($row = mysqli_fetch_array($result)) {
        $messages[] = $row;
        echo $row[0] . "     " . $row[1] . "      " . $row[2] . "<br>";
   }
  // force sending of the next chunk of data  to the client
  ob_flush();
  flush();
}

?>
