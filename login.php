<?php
  include_once 'db.php';

  if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $query = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");

    if($rows = mysqli_fetch_assoc($query)){
      $db_id = $rows['id'];
      $db_pass = $rows['password'];

      $hashed_pwd = password_verify($password, $db_pass);

      if ($hashed_pwd) {
        session_start();

        $_SESSION['id'] = $db_id;
        header("location: index.php");
      } else {
      $login_error = 'Email address or password is incorrect';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat NON GPT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-box">
    <p><?php if (isset($_GET['msg'])) { echo $_GET['msg']; } ?></p>
    <p><?php if (isset($login_error)) { echo $login_error; } ?></p>

    <h1>Login</h1>
    <form action="" method="POST">
      <input type="text" name="email" placeholder="Enter email address"/>
      <input type="password" name="password" placeholder="Enter password"/>
      <input type="submit" name="submit" value="Login"/>
      <a href="registration.php">Register</a>
  </div>
</body>
</html>