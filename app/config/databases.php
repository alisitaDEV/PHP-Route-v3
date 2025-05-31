<?php
//melakukan koneksi dan eksekusi database di sini
class dB {
  private $pdo;

  public function __construct() {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'test';

    try {
      $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Koneksi gagal: " . $e->getMessage());
    }
  }

  public function getUserById($userId) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}

$dB = new dB();



//namun jika daabase anda banyak bisa buat class di dalam folder ../app/databases/
// include FILEAPP . 'databases/userDB.php';
// include FILEAPP . 'databases/articleDB.php';