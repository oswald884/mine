<?php
  $username = "";
  if (isset($_SESSION['userId']) && isset($_SESSION['userName'])) {
    $username = $_SESSION['userName'];
  }

  if (isset($_POST['btn_logout'])) {
    header('Location: logout.php');
    exit();
  }
?>

<!-- NAVIGATION BAR STARTS HERE-->
<nav id="navbar" class="navbar navbar-expand-sm navbar-dark bg-dark" style="border: 1px solid;">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <form class="form-inline my-2 my-lg-0 mr-auto" action="searchResults.php" method="GET">
      <input class="form-control mr-sm-2 searchBox" type="search" placeholder="Kullanıcı, veya etiket" name="search" required>
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Ara</button>
    </form>

    <?php
      if (isset($_SESSION['userId'])) {
        $userImage = "images/default.png";
        if ($_SESSION['userImage'] != "default") {
          $userImage = htmlspecialchars($_SESSION['userImage'], ENT_QUOTES);
        }

        echo('
          <div class="row" style="margin-left: 2px;">
            <a href="profile.php">
            <img src="'.$userImage.'" class="prof-img">
            <span class="username text-white" style="margin-right: 10px; font-size: 18px;">'.
              htmlspecialchars($username, ENT_QUOTES).
            '</span>
            </a>
            <form action="" method="POST" class="form-inline my-2 my-lg-0 mr-auto">
              <button name="btn_logout" class="btn btn-sm btn-outline-danger my-sm-0" style="margin-right: 10px; line-height: 19px; margin-top: 0px; margin-bottom: 25px;" type="submit">Çıkış Yap</button>
            </form>
          </div>
        ');
      }
      else{
        echo('
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="index.php"><span style="font-size: 20px; margin-right: 5px;"><i class="fa fa-home" aria-hidden="true"></i></span>Anasayfa<span class="sr-only">(current)</span></a>
          </li>
        </ul>
        ');
      }
    ?>

  </div>
</nav>
<!-- NAVIGATION BAR ENDS HERE-->
