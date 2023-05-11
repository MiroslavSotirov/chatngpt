<?php 
  include_once 'db.php';
  $sql = mysqli_query($con, "SELECT * FROM post ORDER BY id DESC LIMIT 50");

  $chatLogs = array();

  while ($rows = mysqli_fetch_array($sql)){
    $message = $rows['message'];
    $name = $rows['user_name'];
    $user_image = $rows['user_image'];

    $chatLogs[] = array(
      'name' => $name,
      'user_image' => $user_image,
      'message' => $message
    );
  }
?>

<div class="chatlogs">
  <?php foreach ($chatLogs as $log) { ?>
    <div class="chat users">
      <div class="user-photo"><img src="image/<?php echo $log['user_image']; ?>" alt=""></div>
      <p class="chat-message">
        <span style="color:#9a5803; font-size:14px;"><?php echo $log['name']; ?></span><br>
        <?php echo $log['message']; ?>
      </p>
    </div>
  <?php } ?>
</div>
