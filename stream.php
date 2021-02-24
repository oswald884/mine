<?php
  session_start();
  include_once 'conn.php';
  include 'contentClass.php';

  $hata = false;
  $dbh = new Dbh();
  if (!$dbh->pdo) { // Bağlantı sorunu
    connectionProblem();
    $hata = true;
  }

  if ($hata == false && isset($_POST['btn_like']) && isset($_SESSION['userId'])) { // Like durumu
    $content_id = $_POST['content_id'];

    // Like lar tablosuna ekle
    $sql = "INSERT INTO likes (content_id, user_id) VALUES (?, ?);";
    $varArray = [$content_id, $_SESSION['userId']];
    $dbh->insert($sql, $varArray);

    // Like count u arttır
    $sql="UPDATE contents SET like_count = like_count + 1 WHERE content_id = ?;";
    $varArray= [$content_id];
    $dbh->update($sql, $varArray);

    header("Location: stream.php#".$content_id);
    exit();
  }

  $contents = null;
  if ($hata == false) { // Hata yoksa gönderileri getir
    $contents = getPopularContents($dbh);
  }

  $col1 = array();
  $col2 = array();
  $col3 = array();
  $col4 = array();
  if ($contents != null && $contents != false && $contents->rowCount()) {
    // Contents'i dağıt

    $next = 1;
    while ($row = $contents->fetch()) { // Dizilere birer birer ekle
      $currentContent = new Content;
      $currentContent->content_id = $row['content_id'];
      $currentContent->content_heading= $row['content_heading'];
      $currentContent->content_message = $row['content_message'];
      $currentContent->content_image = $row['content_image'];
      $currentContent->user_id = $row['user_id'];
      $currentContent->like_count = $row['like_count'];
      $currentContent->date_time = $row['date_time'];
      $currentContent->tag = $row['tag'];

      if ($next == 1) {
        array_push($col1, $currentContent);
        $next = 2;
      }
      else if($next == 2){
        array_push($col2, $currentContent);
        $next = 3;
      }
      else if($next == 3){
        array_push($col3, $currentContent);
        $next = 4;
      }
      else if($next == 4){
        array_push($col4, $currentContent);
        $next = 1;
      }
    }

    // Dizileri kart olarak ekrana yaz
  }
  else{ // Hata veya Hiç gönderi yok

  }
?>

<!doctype html>
<html lang="tr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
  <!-- CSS -->
  <link rel="stylesheet" href="css/stream.css">


  <title>Akış</title>
</head>

<body class="bg-dark">

  <?php
    include 'stream-navbar.php';
  ?>

  <h2> <span class="badge badge-secondary" style="margin-left: 3%;">Yakındakiler</span> </h2>
  <!-- STREAM CARDS -->
  <div id="streamGrid" class="m-auto grid">
    <div class="row col-12 m-auto">
      <?php
        if ($col1 == null || count($col1) == 0) {
          echo('
            <div class="col-12 text-center">
              <h4 class="text-white">
                Hiç Gönderi yok
              </h4>
            </div>
          ');
        }
      ?>
      <!-- COL1 -->
      <div class="m-0 p-0 col-12 col-md-6 col-lg-3">
        <?php
          drawContentArray($col1, $dbh);
        ?>
      </div>

      <!-- COL2 -->
      <div class="m-0 p-0 col-12 col-md-6 col-lg-3">
        <?php
          drawContentArray($col2, $dbh);
        ?>
      </div>

      <!-- COL3 -->
      <div class="m-0 p-0 col-12 col-md-6 col-lg-3">
        <?php
          drawContentArray($col3, $dbh);
        ?>
      </div>

      <!-- COL4 -->
      <div class="m-0 p-0 col-12 col-md-6 col-lg-3">

        <?php
          drawContentArray($col4, $dbh);
        ?>
      </div>

    </div>
  </div>

  <div class="space"></div>

  <?php
    include 'main-footer.php';
  ?>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

<?php

  function isContentLiked($contentId, $userId, $dbh){
    if (!$dbh) {
      return false;
    }

    $sql = "SELECT * FROM likes WHERE content_id = ? AND user_id = ?;";
    $varArray = [$contentId, $userId];
    $stmt = $dbh->select($sql, $varArray);

    if (!$stmt) { // Hata
      return false;
    }
    else if(!$stmt->rowCount()){ // Beğenmemiş
      return false;
    }
    else{ // Beğenmiş
      return true;
    }
  }

  function getPopularContents($dbh){
    if (!$dbh) { // DBH'da hata varsa hiçbirşey yapma
      return;
    }

    $sql = "SELECT * FROM contents ORDER BY date_time DESC, like_count DESC LIMIT 20 ;";
    $varArray = null;
    $stmt = $dbh->select($sql, $varArray);
    if (!$stmt || !$stmt->rowCount()) { // Hata var veya hiç gönderi yok
      return false;
    }

    return $stmt; // Gönderileri döndür
  }

  function drawCard($content, $dbh){

    // Profil bilgilerini getir
    $userId = $content->user_id;
    $userImage = "default";
    $userName = "Bilinmiyor";
    $sql="SELECT * FROM users WHERE user_id = ?;";
    $varArray = [$userId];
    $stmt = $dbh->select($sql, $varArray);
    if ($stmt && $stmt->rowCount()) {
      $row = $stmt->fetch();
      $userImage = $row['profile_img'];
      $userName = $row['username'];
    }

    $isLiked = true;
    if (isset($_SESSION['userId'])) {
      $isLiked = isContentLiked($content->content_id, $_SESSION['userId'], $dbh); // Oturumu açık olan kişi tarafından beğenilmiş mi?
    }

    // Card'ı başlat
    echo('<div class="mycard m-auto m-lg-0" id="'.escape($content->content_id).'">');
      echo('<input type="hidden" id="'.escape($content->content_id).'"/>');
    // Card-head'i başlat
    echo('<a href="targetProfile.php?target_user='.$content->user_id.'" style="text-decoration: none; color: black;">');
      echo('<div class="mycard-head">');
        echo('<div class="row card-head-row">');
          echo('<img src="'.getImage($userImage).'" class="prof-img" />');
          echo('<h4 class="username mr-auto">'.escape($userName).'</h4>');
        echo('</div>');
      echo('</div>');
    echo('</a>');
    // Card-body'i başlat
      echo('<div class="mycard-body">');
        if ($content->content_image != null) {
          echo('<img src="'.escape($content->content_image).'" class="img-fluid" />');
        }
        echo('<div class="inner-body">');
          echo('<h4>'.escape($content->content_heading).'</h4>');
          echo('<p> '.escape($content->content_message).' </p>');
          if ($content->tag != null) {
            echo('<div class="badge badge-dark">Tag: #'.escape($content->tag).'</div>');
          }
        echo('</div>');
      echo('</div>');

      if ($isLiked) { // Beğenilmiş
        echo('
          <div class="card-ending">
            <button name="btn_like" type="submit" class="btn" style="padding: 0; color: red;">
            <span class="btn-like" style="color: red;"><i class="fa fa-heart" aria-hidden="true" title="Beğen"></i></span>
            </button>
            <span style="line-height: 20px; margin-right: 5px;">'.escape($content->like_count).'</span>
            <input type="hidden" name="content_id" value="'.escape($content->content_id).'"/>
          </div>
        ');
      }
      else{ // Beğenilmemiş
        echo('
          <div class="card-ending">
            <form action="" method="POST">
            <button name="btn_like" type="submit" class="btn" style="padding: 0;">
            <span class="btn-like"><i class="fa fa-heart" aria-hidden="true" title="Beğen"></i></span>
            </button>
            <span style="line-height: 20px; margin-right: 5px;">'.escape($content->like_count).'</span>
            <input type="hidden" name="content_id" value="'.escape($content->content_id).'"/>
            </form>
          </div>
        ');
      }

    echo('</div>');
  }

  function drawContentArray($contentArray, $dbh){
    for ($i=0; $i < count($contentArray); $i++) {
      drawCard($contentArray[$i], $dbh);
    }
  }

  function getImage($userImage){
    if ($userImage == "default") {
      return "images/default.png";
    }
    else{
      return escape($userImage);
    }
  }

  function escape($string){
    return htmlspecialchars($string, ENT_QUOTES);
  }

  function alert($string){
    echo('<script> alert("'.escape($string).'"); </script>');
  }
?>
