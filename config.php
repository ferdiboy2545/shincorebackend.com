<?php

if (isset($_ENV['MYSQLHOST'])) {
  // Railway
  $conn = new mysqli(
    $_ENV['MYSQLHOST'],
    $_ENV['MYSQLUSER'],
    $_ENV['MYSQLPASSWORD'],
    $_ENV['MYSQLDATABASE']
  );
} else {
  // Localhost
  $conn = new mysqli("localhost", "root", "", "shincore_db");
}

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

?>