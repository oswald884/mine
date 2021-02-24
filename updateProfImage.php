<?php
  session_start();
  include 'checkSession.php';
  include_once 'conn.php';
  $dbh = new Dbh();
  if (!$dbh->pdo) { // Bağlantı sorunu

  }

  var_dump($_FILES);

  if (!isset($_FILES['image'])) { // Resim yoksa profile dön
    header("Location: profile.php");
    exit();
  }

  // Varsa eski resmi sil
  $old = $_SESSION['userImage'];
  if ($old != "default") {
    try {
      unlink($old);
    } catch (\Exception $e) {

    }
  }

  $file = $_FILES['image'];
  $fileName = $file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileSize = $file['size'];
  $fileError = $file['error'];
  $fileType = $file['type'];

  $parcala = explode('.', $fileName);
  $fileExt = strtolower(end($parcala));

  if ($fileExt != 'png' && $fileExt != 'jpg' && $fileExt != 'jpeg') {
    header("Location: profile.php");
    exit();
  }

  $fileNameNew = uniqid('', true).".".$fileExt;
  $fileDestination = 'images/profile/'.$fileNameNew;
  move_uploaded_file($fileTmpName, $fileDestination);
  $img = $fileDestination;

  $userId = $_SESSION['userId'];
  $sql = "UPDATE users SET profile_img = ? WHERE user_id = ?;";
  $varArray = [$img, $userId];
  $result = $dbh->update($sql, $varArray);

  if ($result == true) {
    $_SESSION['userImage'] = $img;
  }

  header("Location: profile.php");
  exit();
?>
