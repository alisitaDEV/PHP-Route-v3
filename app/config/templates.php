<?php
function Template($templateName, $data = []) {
  $filePath = '../app/templates/' . $templateName . '.php';
  if (file_exists($filePath)) {
      extract($data);
      include $filePath;
  } else {
      echo 'Template tidak ditemukan: ' . htmlspecialchars($templateName);
  }
}

function notFound(){
  include "../app/templates/404.php";
}

function includeDB($fileName){
  $filePath = '../app/databases/' . $fileName . '.php';
  if (file_exists($filePath)) {
      include $filePath;
  } else {
      echo 'File : ' . htmlspecialchars($fileName) . ' tidak ditemukan';
  }
}