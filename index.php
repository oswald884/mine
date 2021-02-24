<?php
  session_start();
  if (isset($_SESSION['userId'])) {
    header("Location: stream.php");
    exit();
  }

  include_once 'conn.php';

  $hata = false;
  $dbh = new Dbh();

  if (!$dbh->pdo) { // Bağlanılamadı
    $hata = true;
  }


?>

<!Doctype HTML>
<html lang="tr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <!-- CSS -->
  <link rel="stylesheet" href="./css/index.css">
  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
  <!-- JavaScript -->
  <script src="js/index.js"></script>

  <title>Mine</title>
</head>

<body>

  <?php
    include 'main-navbar.php';
  ?>

  <div id="first-section" class="container-fluid">
    <div id="gorsel1" class=" gorselli">
      <div id="inner1" class="container-fluid text-center text-white">
        <h1>hoşgeldin <span style="font-family: 'zantrokeregular', serif;;">MINE'a</span></h1>

        <a href="#gorsel2"> <button type="button" id="goToLogin" class="btn btn-lg btn-outline-success" style="margin-bottom: 10px;">Giriş yapacağım</button> </a>
        <a href="#register"> <button type="button" id="goToRegister" class="btn btn-lg btn-outline-success" style="margin-bottom: 10px;">Kayıt olacağım</button> </a>
      </div>
    </div>
  </div>

  <div id="break" class="container-fluid bg-dark text-center">
    <p class="text-white orta-yazi">Onların,senin,benim... Mine bizim sevdiklerimizden :)</p>
  </div>

  <div id="first-section" class="container-fluid">
    <div id="gorsel2" class=" gorselli">
      <div id="inner2" class="container-fluid text-center text-white">
        <div id="form-div" class="container-fluid text-center border-success">
          <h1>Giriş Yap</h1>
          <!-- Hata için -->
          <div id="loginError" class="container">
            <?php
              if (isset($_GET['lerr'])) {
                if ($_GET['lerr'] == "sth") {
                  alertHata("Bağlantı hatası!");
                }
                else if ($_GET['lerr'] == "misInfo") {
                  alertHata("Eksik bilgi!");
                }
                else if($_GET['lerr'] == "fail"){
                  alertHata("Email veya şifre hatalı.");
                }
              }
            ?>
          </div>
          <form id="loginForm" action="login.php" method="POST" onsubmit="event.preventDefault(); validateLoginForm();">
            <div class="form-group text-center">
              <label for="loginEmail">Email</label>
              <input type="email" class="form-control textbox m-auto" id="loginEmail" name="loginEmail" aria-describedby="emailHelp" required>
            </div>
            <div class="form-group text-center">
              <label for="loginPassword">Şifre</label>
              <input type="password" class="form-control textbox m-auto" id="loginPassword" name="loginPassword" required>
            </div>
            <button id="btn_login" type="submit" class="btn btn-lg btn-success myBtn">Giriş Yap</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="break" class="container-fluid bg-dark text-center">
    <div class="container text-white text-center">
      <p class="text-center orta-yazi">Kimler neler paylaşmış? Uzaklarda neler beğenilmiş? Keşfete uğraman gerek!
        Sevdiklerini profiline taşı. Biyografine seni tanımaları için minik bilgiler ekle.
        Kategorize edilmiş fotoğraf ve giflerle tanış. Seni aramızda görmeliyiz. İyi eğlenceler :)</p>
    </div>
  </div>

  <div id="first-section" class="container-fluid">
    <div id="gorsel3" class=" gorselli">
      <div id="inner3" class="container-fluid text-center text-white">
        <div id="form-div" class="container-fluid text-center border-success">
          <h1 id="register">Kayıt Ol</h1>
          <!-- Hata için -->
          <div id="registerError" class="container">
            <?php
              // Get ile hata var mı kontrol et
              if (isset($_GET['err'])) {
                if ($_GET['err'] == "misInfo") { // Eksik bilgi
                  alertHata("Eksik bilgi girdiniz.");
                }
                else if($_GET['err'] == "sth"){
                  alertHata("Bağlantı sorunu!");
                }
                else if($_GET['err'] == "emUsed"){
                  alertHata("Bu email kullanılmış. Farklı bir email deneyin.");
                }
              }
            ?>
          </div>
          <form id="registerForm" action="register.php" method="POST" onsubmit="event.preventDefault(); validateRegisterForm();">
            <div class="form-group text-center">
              <label for="registerUsername">Kullanıcı Adı</label>
              <input type="text" class="form-control textbox m-auto" id="registerUsername" name="registerUsername" required>
            </div>

            <div class="form-group text-center">
              <label for="registerEmail">Email</label>
              <input type="email" class="form-control textbox m-auto" id="registerEmail" name="registerEmail" aria-describedby="emailHelp" required>
            </div>

            <div class="form-group text-center">
              <label for="registerPassword">Şifre</label>
              <input type="password" class="form-control textbox m-auto" id="registerPassword" name="registerPassword" required>
            </div>
            <button id="btn_register" type="submit" class="btn btn-lg btn-success" style="margin-top: 30px; padding-left: 20px; padding-right: 20px; padding-top: 10px; padding-bottom: 10px;">Kayıt ol</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <?php
    include 'main-footer.php';
  ?>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>

<?php
  function alert($string){
    echo ("<script> alert('".htmlspecialchars($string, ENT_QUOTES)."'); </script>");
  }

  function alertHata($string){
    echo('
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        '.htmlspecialchars($string, ENT_QUOTES).'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    ');
  }
?>
