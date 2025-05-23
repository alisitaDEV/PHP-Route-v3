<?php
class dbUser {
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

  public function insertUser($nama, $email) {
    $stmt = $this->pdo->prepare("INSERT INTO users (nama, email) VALUES (?, ?)");
    if ($stmt->execute([$nama, $email])) {
      $id = $this->pdo->lastInsertId();
      return $this->getUserById($id);
    }
    return false;
  }

  public function getUserById($userId) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}

$dbUser = new dbUser();