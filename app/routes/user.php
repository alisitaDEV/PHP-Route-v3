<?php
$title  = "User";

$user   = $dB->getUserById(1);

if ($user) {
  print_r($user);
} else {
  echo "Data user tidak ditemukan.";
}