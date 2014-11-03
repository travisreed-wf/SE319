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
<h2>Messages</h2>
<div id="myDiv1">My Div</div>
<div id="messages"></div><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
</body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>

function getMessages() {
  var url = 'getInitialMessages.php?username=' + $('#user').text();
  var url2 = 'getMessages.php?username=' + $('#user').text();
  $.ajax({
      async: false,
      url: url,
      type: 'GET',
      data: "",
      success: function(result){
        $('#myDiv1').html(result);
      }
  })
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if(xhr.readyState == 3) {
      $("#messages").html(xhr.responseText);
      console.log(xhr.responseText);
    }
    else if (xhr.readyState == 4) {
      $("#messages").html(xhr.responseText);
      console.log(xhr.responseText);

    }
  };
  xhr.open("get",url2,true); 
  xhr.send(null);
}

function getFollowers(){
  var url = 'getInitialFollowers.php?username=' + $('#user').text();
  $.ajax({
      url: url, 
      type: 'GET',
      data: "",
      success: function(result){
        $('#followers').html(result);
      }
    });
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if(xhr.readyState == 3) {
      $('#followers').html(xhr.responseText);
    }
    else if (xhr.readyState == 4) {
      $('#followers').html(xhr.responseText);
    }
  };
  xhr.open("get",url,true); 
  xhr.send(null);
}

function addUser(){
  var row = $(this).closest('tr');
  var user = $(this).parent().prev().prev().text();
  $.ajax({
      url: 'startFollowing.php', 
      type: 'GET',
      data: "username=" + user,
      success: function(result){
        row.remove();
        $('#follow').append(user + "<br>");
      }
    })
}
$(document).ready(function(){
    $.ajax({
        url: 'updateFollowing.php', 
        type: 'GET',
        data: "",
        success: function(result){
          $('#follow').html(result);
        }
    })
    getMessages();
    getFollowers();
});
$('#btnFollow').click(function(){
  var table = "<table border=1>";
  table += "<th>Username</th><th>Follower Count</th><th>Add</th>";
  $.ajax({
    url: 'allUsers.php', 
      type: 'GET',
      data: "",
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