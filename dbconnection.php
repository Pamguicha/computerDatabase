<?php

$dsn = "mysql:host=localhost;dbname=computerForce";
$databaseUsername = 'santa';
$databasePassword = '1234';

// Connect to database

try {
  $conn = new PDO($dsn, $databaseUsername, $databasePassword);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Database connected";
} catch (PDOException $e) {
  echo "Connection Failed: " . $e->getMessage();
  $conn = null;
}




