<?php
$routeFolder = '../app/routes/';

$route = isset($urlParts[0]) ? $urlParts[0] : '';
$parameter = isset($urlParts[1]) ? $urlParts[1] : '';

// Validasi karakter URL (hindari karakter berbahaya)
if ((!empty($route) && !preg_match('/^[a-zA-Z0-9_-]+$/', $route)) ||
  (!empty($parameter) && !preg_match('/^[a-zA-Z0-9_-]+$/', $parameter))) {
  die('Invalid URL');
}

// Jika tidak ada route, arahkan ke home
if ($route === '') {
  $filePath = $routeFolder . 'home/index.php';
  if (file_exists($filePath)) {
    include $filePath;
    exit;
  } else {
    notFound();
  }
}

// Coba akses sebagai folder/index.php → /page1 → routes/page1/index.php
if (is_dir($routeFolder . $route)) {
  $filePath = $routeFolder . $route . '/index.php';

  // Jika ada subhalaman seperti /page1/sub1 → routes/page1/sub1.php
  if (!empty($parameter)) {
    $subFile = $routeFolder . $route . '/' . $parameter . '.php';
    if (file_exists($subFile)) {
      include $subFile;
      exit;
    }
  }

  if (file_exists($filePath)) {
    include $filePath;
    exit;
  }
}

// Coba akses langsung file php → /page2 → routes/page2.php
$directFile = $routeFolder . $route . '.php';
if (file_exists($directFile)) {
  include $directFile;
  exit;
}

// Tidak ditemukan
notFound();
