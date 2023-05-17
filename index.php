<?php
  include_once 'db.php';

  if (!isset($_SESSION['id'])){
    header('location: login.php');
  }

  $id = $_SESSION['id'];

  $userdata = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users WHERE id = '$id'"));

  $username = $userdata['name'];
  $image = $userdata['image'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat NON GPT</title>
    <link rel="stylesheet" href="style.css">
    <script>
      function ajax() {
      var req = new XMLHttpRequest();
      req.onreadystatechange = function() {
        if (req.readyState == 4 && req.status == 200) {
          var chatContainer = document.getElementById('chat');
          var currentScrollPos = chatContainer.scrollTop;
          var newChatLogs = req.responseText;
          
          var tempContainer = document.createElement('div');
          tempContainer.innerHTML = newChatLogs;
          
          if (tempContainer.innerHTML !== chatContainer.innerHTML) {
            chatContainer.innerHTML = newChatLogs;
          }
          
          chatContainer.scrollTop = currentScrollPos;
        }
      };
      req.open('GET', 'chat.php', true);
      req.send();
    }


    </script>
</head>
<body onload="ajax();">
  <div class="container">
    <div id="chatlogs" class="chatlogs">
      <div id="chat" class="chat users"></div>
    </div>
    <form action="" class="chat-form" method="post">
      <textarea name="chat" placeholder="Enter message"></textarea>
      <button type="submit" name="send">Send</button>
      <a href="logout.php" class="logout_button">Logout</a>
    </form>
  </div>

  <?php 
    if (isset($_POST['send']) && !empty($_POST['chat'])) {
      $msg = $_POST['chat'];

      $insert_query = mysqli_query($con, "INSERT INTO post(user_name, user_image, message) VALUES('$username', '$image', '$msg')");
    }
  ?>

</body>
</html>