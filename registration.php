<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');

  include_once './db.php';

  $errors = array();
  
  // check if the registration form has been submitted
  if (isset($_POST['submit'])){
    $username = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);


    $image = $_FILES['photo']['name'];
    $target = 'images/' . basename($image);

    $email_check_query = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' LIMIT 1");
    $email_check = mysqli_fetch_assoc($email_check_query);

    if (empty($username)){
      array_push($errors, 'Username is required');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      array_push($errors, 'Please enter a valid email address');
    }

    if (strlen($password) < 8){
      array_push($errors, 'Password must contain at least 8 characters');
    }

    if ($email_check) {
      array_push($errors, "Email already exists");
    }

    if (count($errors) == 0){
      move_uploaded_file($_FILES['photo']['tmp_name'], $target);

      $pwdhash = password_hash($password, PASSWORD_DEFAULT);

      $query = "INSERT INTO users(name, email, password, image) VALUES('$username', '$email', '$pwdhash', '$image')";

      if (mysqli_query($con, $query)){
        header('Location: login.php?msg='.urlencode('Registration Successful'));
      } else {
        array_push($errors, "Registration failed, please try again");
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
  <div class="registration-container">
    <div class="registration-box">
      <h1>Register Here</h1>
      <p><?php if (in_array("Registration failed, please try again", $errors)){
        echo "Registration failed, please try again"; } ?></p>
      <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Enter username" required/>
        <p><?php if (in_array("Username is required", $errors)){
          echo "Username is required"; } ?></p>
        <input type="email" name="email" placeholder="Enter email" required/>
        <p><?php if (in_array("Please enter a valid email address", $errors)){
          echo "Please enter a valid email address"; } ?></p>
        <p><?php if (in_array("Email already exists", $errors)) { echo "Email already exists"; } ?></p>
        <input type="password" name="password" placeholder="Enter password" required/>
        <p><?php if (in_array("Password must contain at least 8 characters", $errors)){
          echo "Password must contain at least 8 characters"; } ?></p>
        <input type="file" name="photo" required/>
        <input type="submit" name="submit" value="Join"/>
        <a href="login.php">Already Registered</a>
      </form>
    </div>
  </div>
</body>
</html>