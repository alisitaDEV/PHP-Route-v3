<?php
session_start();
error_reporting(0);

// Konstanta path dan base URL
define("BASEURL", "//" . $_SERVER['SERVER_NAME']);
define("FILEAPP", __DIR__ . "/");

// Ambil URL dari parameter GET
$url = isset($_GET['url']) ? $_GET['url'] : '';
$urlParts = explode('/', trim($url, '/'));

// Fungsi untuk memuat template
function Template($templateName, $data = []) {
    $filePath = FILEAPP . 'templates/' . $templateName . '.php';
    if (file_exists($filePath)) {
        extract($data);
        include $filePath;
    } else {
        echo 'Template tidak ditemukan: ' . htmlspecialchars($templateName);
    }
}

// Fungsi error 404
function notFound() {
    include FILEAPP . "templates/404.php";
}

// Fungsi untuk memuat file dari folder databases/
function includeDB($fileName) {
    $filePath = FILEAPP . 'databases/' . $fileName . '.php';
    if (file_exists($filePath)) {
        include $filePath;
    } else {
        echo 'File database tidak ditemukan: ' . htmlspecialchars($fileName);
    }
}

// Koneksi database via PDO
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

$dB = new dB();

$routeFolder = FILEAPP . 'routes/';
$route = $urlParts[0] ?? '';
$parameter = $urlParts[1] ?? '';

// Validasi karakter untuk keamanan
if ((!empty($route) && !preg_match('/^[a-zA-Z0-9_-]+$/', $route)) ||
    (!empty($parameter) && !preg_match('/^[a-zA-Z0-9_-]+$/', $parameter))) {
    die('Invalid URL');
}

// Jika route kosong, muat routes/home/index.php
if ($route === '') {
    $filePath = $routeFolder . 'home/index.php';
    if (file_exists($filePath)) {
        include $filePath;
        exit;
    } else {
        notFound();
        exit;
    }
}

// Jika berupa folder, cek file index.php dan sub-file
if (is_dir($routeFolder . $route)) {
    if (!empty($parameter)) {
        $subFile = $routeFolder . $route . '/' . $parameter . '.php';
        if (file_exists($subFile)) {
            include $subFile;
            exit;
        }
    }

    $filePath = $routeFolder . $route . '/index.php';
    if (file_exists($filePath)) {
        include $filePath;
        exit;
    }
}

// Jika file langsung
$directFile = $routeFolder . $route . '.php';
if (file_exists($directFile)) {
    include $directFile;
    exit;
}

// Jika semua gagal, tampilkan 404
notFound();
exit;
