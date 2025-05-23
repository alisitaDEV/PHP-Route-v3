<?php
//database artikel

// class dbArticle {
//   private $pdo;

//   public function __construct() {
//     $host = 'localhost';
//     $username = 'root';
//     $password = '';
//     $dbname = 'article';

//     try {
//       $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
//       $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     } catch (PDOException $e) {
//       die("Koneksi gagal: " . $e->getMessage());
//     }
//   }
// }

// $dbArticle = new dbArticle();