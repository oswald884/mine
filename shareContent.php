<?php
  session_start();
  include 'checkSession.php';

  include_once 'conn.php';
  $dbh = new Dbh();
  if (!$dbh->pdo) { // Bağlantı sorunu
    connectionProblem();
  }

  if (!isset($_POST['heading'])) {
    // Eksik bir bilgi var ise
    header("Location: http://localhost/staj/share.php?err=misInfo");
    exit();
  }

  $heading = $_POST['heading'];
  $message = $_POST['message'];
  $img = null;
  $etiket = NULL;
  $userId = $_SESSION['userId'];

  // Etiket varsa al
  if (isset($_POST['etiket']) && $_POST['etiket'] != "") {
    $etiket = $_POST['etiket'];
  }

  // Resim varsa al
  if (isset($_FILES['imgFile'])) {
    $file = $_FILES['imgFile'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $parcala = explode('.', $fileName);
    $fileExt = strtolower(end($parcala));

    if ($fileExt == 'png' || $fileExt == 'jpg' || $fileExt == 'jpeg') {
      $fileNameNew = uniqid('', true).".".$fileExt;
      $fileDestination = 'images/contents/'.$fileNameNew;
      move_uploaded_file($fileTmpName, $fileDestination);
      $img = $fileDestination;
    }

  }


  // Veri Tabanına kaydet
  $sql = "INSERT INTO contents (content_heading, content_message, content_image, user_id, tag) VALUES (?, ?, ?, ?, ?);";
  $varArray = [$heading, $message, $img, $userId, $etiket];
  if ($dbh->insert($sql, $varArray)) { // Paylaşıldı

    // Kullanıcının content_count 'ını arttır
    $sql = "UPDATE users SET content_count = content_count + 1 WHERE user_id = ?;";
    $varArray = [$userId];
    $result = $dbh->update($sql, $varArray);

    header("Location: profile.php?shr=succ");
    exit();
  }else{ // Paylaşılamadı
    header("Location: share.php?shr=fail");
    exit();
  }

  // ************************************************************************
  function connectionProblem(){ // Bağlantı sorunu olursa akışa götür
    header("Location: http://localhost/staj/index.php");
    exit();
  }
?>
