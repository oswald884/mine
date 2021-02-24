<?php
  session_start();
  include 'checkSession.php';

  $username = $_SESSION['userName'];
  $email = $_SESSION['userEmail'];
  $userImage = $_SESSION['userImage'];

?>

<!doctype html>
<html lang="tr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <!-- CSS -->
  <link rel="stylesheet" href="css/share.css">
  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
  <title>Paylaş</title>
</head>

<body class="bg-dark">

  <div class="container-fluid" name="errorDiv" id="errorDiv">
    <?php
      if (isset($_GET['err'])) {
        alertHata("Eksik bilgiler girdiniz.");
      }
    ?>
  </div>

  <form id="shareForm" action="shareContent.php" method="post" onsubmit="event.preventDefault(); validateShareForm();" enctype="multipart/form-data">
    <div class="mycard m-auto">
      <div class="mycard-head">
        <div class="row card-head-row">
          <img src="<?php
            getProfImage($userImage);
          ?>" class="prof-img" />
          <h4 class="username mr-auto">
            <?php
              if ($username != null && $username != "") {
                echo(escape($username));
              }
            ?>
          </h4>
        </div>
      </div>

      <div class="mycard-body">
        <div style="width: 100%; height: auto;">
          <div class="carousel-inner" style="height: auto;">
            <div class="carousel-item active">
              <img id="imgChosen" src="images/gray.jpg" class="d-block w-100" style="max-height: 450px;">
              <div class="carousel-caption">
                <div class="form-group">
                  <label id="temp" for="imgFile" class="btn btn-img" style="background: rgba(99, 207, 89, 0.9); padding: 5px;"><i class="fa fa-plus-circle"></i>  Resim Ekle </label>
                  <input class="inputfile" type="file" id="imgFile" name="imgFile" onchange="getImage()">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="inner-body">
          <div class="form-group">
            <label for="headingTextarea">Başlık (40 karakter)</label>
            <textarea class="form-control" id="headingTextarea" name="heading" maxlength="40" rows="2" required></textarea>
          </div>

          <div class="form-group">
            <label for="messageTextarea">İçerik (500 karakter)</label>
            <textarea class="form-control" id="messageTextarea" name="message" maxlength="500" rows="5" required></textarea>
          </div>

          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">#</span>
            </div>
            <input type="text" aria-label="First name" class="form-control" name="etiket" placeholder="(max. 40 karakter)" maxlength="40">
          </div>
          <br>
          <button class="btn col-12 btn-success" type="submit" name="btn_share"><i class="fa fa-share"></i> Paylaş </button>
        </div>
      </div>
      <div class="card-ending">
        <span class="btn-like"><i class="fa fa-heart" aria-hidden="true" title="Beğen"></i></span>
        <span style="line-height: 20px; margin-right: 5px;">189.000</span>
      </div>
    </div>
  </form>

  <div class="col-12" style="height: 40px;">
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="js/share.js"></script>
</body>

<?php
  function escape($string){
    return htmlspecialchars($string, ENT_QUOTES);
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

  function getProfImage($userImage){
    if ($userImage == "default") {
      echo "images/default.png";
    }
    else{
      echo escape($userImage);
    }
  }
?>
