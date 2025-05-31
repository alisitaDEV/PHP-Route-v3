<?php
function notFound() {
  global $isSPA;
  $title = "404 - Tidak Ditemukan";
  ob_start();
  include FILEAPP . 'templates/404.php';
  $content = ob_get_clean();
  if ($isSPA) {
      echo json_encode(['title' => $title, 'content' => $content]);
  } else {
      include FILEAPP . 'templates/layout.php';
  }
  exit;
}

// function includeDB($fileName){
//   $filePath = '../app/databases/' . $fileName . '.php';
//   if (file_exists($filePath)) {
//       include $filePath;
//   } else {
//       echo 'File : ' . htmlspecialchars($fileName) . ' tidak ditemukan';
//   }
// }