<?php
  session_start();
  unset($_SESSION["userId"]);
  unset($_SESSION["userName"]);
  unset($_SESSION["email"]);

  header("Location: stream.php");
  exit();
?>
