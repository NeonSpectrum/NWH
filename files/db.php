<?php
require_once 'strings.php';
require_once 'functions.php';

$servername = "localhost";
$username   = "cp018101";
$password   = PASSWORD;
$database   = "cp018101_nwh";

$db = mysqli_connect($servername, $username, $password, $database);
if (!$db) {
  die("Connection failed: " . $db->connect_error);
}
?>