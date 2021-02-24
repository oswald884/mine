<?php
  if (!isset($_SESSION['userId'])) {
    header("Location: index.php");
    exit();
  }
?>
