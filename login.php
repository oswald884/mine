<?php
session_start();

include_once 'conn.php';

$dbh = new Dbh();
if (!$dbh->pdo) { // Bağlantı sorunu
  connectionProblem();
}

if (!isset($_POST['loginEmail']) || !isset($_POST['loginPassword'])) {
  // Eksik bir bilgi var ise
  header("Location: http://localhost/staj/index.php?lerr=misInfo#gorsel2");
  exit();
}

$email = $_POST['loginEmail'];
$password = $_POST['loginPassword'];

$sql = "SELECT * FROM Users WHERE email = ?;";
$varArray = [$email];
$stmt = $dbh->select($sql, $varArray);
if (!$stmt) { // Bağlantı sorunu
  connectionProblem();
}
else if($stmt->rowCount() == 0){ // Böyle bir kullanıcı yok
  failedToLogin();
}
else{ // Mail doğru şifreyi kontrol et
  $row = $stmt->fetch();
  $dbPassword = $row['password'];
  if (!password_verify($password, $dbPassword)) { // Hatalı şifre
    failedToLogin();
  }
  else{ // Email ve şifre doğru, Oturum aç
    $_SESSION['userId'] = $row['user_id'];
    $_SESSION['userName'] = $row['username'];
    $_SESSION['userEmail'] = $row['email'];
    $_SESSION['userImage'] = $row['profile_img'];

    header("Location: http://localhost/staj/stream.php");
    exit();
  }
}

function connectionProblem(){
  header("Location: http://localhost/staj/index.php?lerr=sth#gorsel2");
  exit();
}

function failedToLogin(){
  header("Location: http://localhost/staj/index.php?lerr=fail#gorsel2");
  exit();
}
?>
