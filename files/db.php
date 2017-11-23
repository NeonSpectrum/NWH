<?php
  require_once 'strings.php'; //link strings php
  
  $servername = "neonspectrumdb.redirectme.net";
  $username = "NeonSpectrum";
  $password = PASSWORD;
  $database = "nwh";

  if ($_SERVER['SERVER_NAME'] != "localhost" && $_SERVER['SERVER_NAME'] != "localhost.nwh" ) {
    $db = mysqli_connect($servername, $username, $password, $database);
  } else {
    $db = mysqli_connect("localhost", "root", $password, $database);
  }
  if (!$db)
  {
    die("Connection failed: " . $db->connect_error);
  }
?>