
<?php
  class User{
    public $userId;
    public $userName;
    public $userEmail;
    public $profileImg;
    public $followerCount;
    public $contentCount;

    function drawCard(){
      echo('
      <a class="linker" style="height: 100px; color: black; text-decoration: none;" href="targetProfile.php?target_user='.$this->userId.'">
      <div class="userCard rounded">
        <img src="'.$this->getPhoto($this->profileImg).'" class="us-img float-left" alt="">

        <div class="float-left">

          <h3>'.htmlspecialchars($this->userName, ENT_QUOTES).'</h3>

          <h4>'.htmlspecialchars($this->userEmail, ENT_QUOTES).'</h4>
        </div>
      </div>
      </a>

      ');
    }

    function getPhoto($string){
      if ($string == "default") {
        return 'images/default.png';
      }
      else{
        return htmlspecialchars($string, ENT_QUOTES);
      }
    }
  }
?>
