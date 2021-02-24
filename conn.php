
<?php

class Dbh{
  private $servername;
  private $username;
  private $password;
  private $dbname;
  private $charset;
  public $pdo;

  public function __construct(){
    $this->servername = "localhost";
    $this->username = "root";
    $this->password = "";
    $this->dbname = "mine";
    $this->charset = "utf8mb4";

    $this->connect();
  }

  public function connect(){
    try {
      $dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname.";charset=".$this->charset;
      $this->pdo = new PDO($dsn, $this->username, $this->password);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return true;
    } catch (PDOException $e) {
      return false;
    }
    return false;
  }

  // INSERT FONKSİYONU
  public function insert($sql, $varArray){
    $pdo = $this->pdo;
    if (!$pdo) {
      return false;
    }

    try {
      $stmt = $pdo->prepare($sql);
      if (!$stmt) {
        return false;
      }

      if (!$stmt->execute($varArray)) {
        return false;
      }

      return true;
    } catch (\Exception $e) {
      return false;
    }
  }

  // SELECT FONKSİYONU
  public function select($sql, $varArray){
    $pdo = $this->pdo;
    if (!$pdo) {
      return false;
    }

    try {
      if ($varArray != null) {
        $stmt = $pdo->prepare($sql);
        if (!$stmt) {
          return false;
        }

        $stmt->execute($varArray);
        return $stmt;
      }else{
        $stmt = $pdo->query($sql);
        if (!$stmt) {
          return false;
        }

        return $stmt;
      }
    } catch (\Exception $e) {
      return false;
    }
    return false;
  }

  public function update($sql, $varArray){
    $pdo = $this->pdo;
    if (!$pdo) {
      return false;
    }

    try {
      if ($varArray != null) {
        $stmt = $pdo->prepare($sql);
        if (!$stmt) {
          return false;
        }

        $stmt->execute($varArray);
        return true;
      }else{
        $stmt = $pdo->query($sql);
        if (!$stmt) {
          return false;
        }

        return true;
      }
    } catch (\Exception $e) {
      return false;
    }
    return false;
  }

  function alert($string){
    echo ("<script> alert('".htmlspecialchars($string, ENT_QUOTES)."'); </script>");
  }
}
?>
