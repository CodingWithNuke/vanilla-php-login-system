<?php
if (empty($_SESSION['_id'])) {
  header('Location: http://' . $_SERVER['SERVER_NAME'] . '/login.php');
}
