<?php
  session_start();

  $host = 'localhost';
  $user = 'root';
  $password = '';
  $db_name = 'chatngpt';

  $con = mysqli_connect($host, $user, $password, $db_name);

  if (!$con) {
    echo 'unable to connect to database'.mysqli_error($con);
  }


?>