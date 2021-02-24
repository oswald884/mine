<?php
  session_start();

  include_once 'conn.php';

  $dbh = new Dbh();
  if (!$dbh->pdo) { // Bağlantı sorunu
    connectionProblem();
  }

  if (!isset($_POST['registerUsername']) || !isset($_POST['registerEmail']) || !isset($_POST['registerPassword'])) {
    // Eksik bir bilgi var ise
    header("Location: http://localhost/staj/index.php?err=misInfo#register");
    exit();
  }

  // Eksik bilgi yok ise
  $username = $_POST['registerUsername'];
  $email = $_POST['registerEmail'];
  $password = $_POST['registerPassword'];

  // Bu email kullanılmış mı?
  $sql = "SELECT email FROM users WHERE email = ?;";
  $varArray = [$email];
  $stmt = $dbh->select($sql, $varArray);
  if (!$stmt) { // Bağlantı sorunu
    connectionProblem();
  }
  else if($stmt->rowCount() != 0){ // Email kullanılmış
    emailUsed();
  }

  // Şifreyi hashle
  $hashedpw = password_hash( $password, PASSWORD_DEFAULT);

  // Veri tabanına kaydet
  $sql = "INSERT INTO Users (username, email, password) VALUES (?, ?, ?);";
  $varArray = [ $username, $email, $hashedpw];
  $value = $dbh->insert($sql, $varArray);

  if (!$value) { // Kayıt edilemedi
    header("Location: http://localhost/staj/index.php?err=sth#register");
    exit();
  }

  // Kayıt Edildi, oturum aç ve Anasayfaya git
  $sql = "SELECT * FROM users WHERE email = ?;";
  $varArray = [$email];
  $stmt = $dbh->select($sql, $varArray);
  if ($stmt && $stmt->rowCount()) {
    $row = $stmt->fetch();
    $_SESSION['userId'] = $row['user_id'];
    $_SESSION['userName'] = $row['username'];
    $_SESSION['userEmail'] = $row['email'];
    $_SESSION['userImage'] = $row['profile_img'];
  }


  header("Location: http://localhost/staj/stream.php");
  exit();

  // ************************************************************************
  function connectionProblem(){
    header("Location: http://localhost/staj/index.php?err=sth#register");
    exit();
  }

  function emailUsed(){
    header("Location: http://localhost/staj/index.php?err=emUsed#register");
    exit();
  }
?>
