<?php 

session_start();
$username = $_SESSION["username"];

echo "<div id='head'><p align='right' id='user'>" . $username ."</p></div>";

?>

<html>
<head>
<title>Home</title>
</head>
<body>
<h2>Messages</h2>
<div id="messages"></div><br>
<h2>Currently Following</h2>
<div id="follow"></div><br>
<input type="button" id="btnFollow" value="Follow Someone New">
<div id="userTable"></div>
<h2>Followers</h2>
<div id="followers"></div><br>
<h2>Post</h2>
<div id="post">
  <br>
  <textarea placeholder="Post Your Message Here" maxlength="140" id="postMessage" rows="3" cols="50"></textarea>  
  <button id="postButton">Post </button>
</div><br>
</body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>

function refreshView(){
    return
}
function addUser(){
  var user = $(this).parent().prev().prev().text();
  $.ajax({
       url: 'startFollowing.php', 
       type: 'GET',
       data: "username=" + user + "&followerName=" + username,
       success: function(result){
            $('#follow').html(result);
       }
    })
}
$(document).ready(function(){
    $.ajax({
       url: 'updateFollowers.php', 
       type: 'GET',
       data: "username=Travis",
       success: function(result){
            $('#followers').html(result);
       }
    });
    $.ajax({
       url: 'updateFollowing.php', 
       type: 'GET',
       data: "username=Travis",
       success: function(result){
            $('#follow').html(result);
       }
    })
});
$('#btnFollow').click(function(){
  var table = "<table border=1>";
  table += "<th>Username</th><th>Follower Count</th><th>Add</th>";
  $.ajax({
    url: 'allUsers.php', 
      type: 'GET',
      data: "username=Travis",
      success: function(result){
        table += result;
        table += "</table>";
        $('#userTable').html(table);
        $('.startFollowing').click(addUser);
      }
  });

});
$("#postButton").click(function(){ 
  $.ajax({
       url: 'sendMessage.php', 
       type: 'GET',
       data: "message="+ $("#postMessage").val(),
       success: function(result){
            console.log("success");
            console.log(result);
            $("#postMessage").val("");


       }
    });
});


</script>