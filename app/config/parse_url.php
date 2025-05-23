<?php
$url = isset($_GET['url']) ? $_GET['url'] : '';
$urlParts = explode('/', trim($url, '/'));