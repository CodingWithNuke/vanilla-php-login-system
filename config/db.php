<?php
session_start();

$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_database = 'login_system';
try {
  $db = new PDO("mysql:host=$db_host;dbname=$db_database;charset=utf8mb4", $db_username, $db_password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $err) {
  echo 'Connection failed: ' . $err->getMessage();
}
