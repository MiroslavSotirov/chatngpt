<?php
  include_once 'db.php';

  // check if the login form has been submitted
  if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Retrieve user data from the database based on the email
    $query = mysqli_prepare($con, "SELECT id, password FROM users WHERE email = ?");
    mysqli_stmt_bind_param($query, "s", $email);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);

    if($row = mysqli_fetch_assoc($result)){
      $db_id = $row['id'];
      $db_pass = $row['password'];

      // Verify the hashed password
      if (password_verify($password, $db_pass)) {
        session_start();

        $_SESSION['id'] = $db_id;
        header("location: index.php");
        exit();
      } else {
        $login_error = 'Email address or password is incorrect';
      }
    } else {
      $login_error = 'Email address or password is incorrect';
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
  <div class="login-container">
    <div class="login-box">
      <h1>Login</h1>
      <form action="" method="POST">
        <input type="text" name="email" placeholder="Enter email address" required/>
        <input type="password" name="password" placeholder="Enter password" required/>
        <input type="submit" name="submit" value="Login"/>
        <a href="registration.php">Register</a>
      </form>
      <?php if (isset($login_error)) { ?>
        <p class="error"><?php echo $login_error; ?></p>
      <?php } ?>
    </div>
  </div>
</body>
</html>
