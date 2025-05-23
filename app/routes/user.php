<?php
$data['title']= "User";
Template('header', $data);

$user         = $dbUser->getUserById(1);

if ($user) {
  print_r($user);
} else {
  echo "Data user tidak ditemukan.";
}

Template('footer');