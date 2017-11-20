<?php
  $root = isset($root) ? $root : ''; //issues
  require_once $root.'../files/strings.php'; //link strings php
  
  $servername = "neonspectrumdb.redirectme.net";
  $username = "NeonSpectrum";
  $password = PASSWORD;
  $database = "nwh";

  if ($_SERVER['SERVER_NAME'] != "localhost") {
    $db = mysqli_connect($servername, $username, $password, $database);
  } else {
    $db = mysqli_connect("localhost", "root", $password, $database);
  }
  if (!$db)
  {
    die("Connection failed: " . $db->connect_error);
  }
?>