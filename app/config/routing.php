<?php
$routeFolder  = FILEAPP . 'routes/';
$route        = isset($urlParts[0]) ? $urlParts[0] : '';
$parameter    = isset($urlParts[1]) ? $urlParts[1] : '';

if ((!empty($route) && !preg_match('/^[a-zA-Z0-9_-]+$/', $route)) ||
  (!empty($parameter) && !preg_match('/^[a-zA-Z0-9_-]+$/', $parameter))) {
  die('Invalid URL');
}

ob_start();
$title        = 'Halaman';

$found        = false;

if ($route  === '') {
  $filePath   = $routeFolder . 'home/index.php';
  if (file_exists($filePath)) {
    include $filePath;
    $found    = true;
  }
} elseif (is_dir($routeFolder . $route)) {
  if (!empty($parameter)) {
    $subFile  = $routeFolder . $route . '/' . $parameter . '.php';
    if (file_exists($subFile)) {
      include $subFile;
      $found  = true;
    }
  }

  if (!$found) {
    $filePath = $routeFolder . $route . '/index.php';
    if (file_exists($filePath)) {
      include $filePath;
      $found  = true;
    }
  }
} else {
  $directFile = $routeFolder . $route . '.php';
  if (file_exists($directFile)) {
    include $directFile;
    $found    = true;
  }
}

$content      = ob_get_clean();

if (!$found) {
  notFound();
}

$isSPA = isset($_GET['spa']) && $_GET['spa'] ? true : false;

if ($isSPA) {
  header('Content-Type: application/json');
  echo json_encode([
    'title' => $title,
    'content' => $content
  ]);
} else {
  include FILEAPP . 'templates/layout.php';
}