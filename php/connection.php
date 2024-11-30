<?php

$dsn = "mysql:host=localhost;dbname=vivalavida_pos";
$username = "root";
$pasworrd = "";

try {
  $pdo = new PDO($dsn, $username, $pasworrd);

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Error" . $e->getMessage();
}

?>