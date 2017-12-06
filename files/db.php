<?php
  require_once 'strings.php';
  require_once 'functions.php';
  
  $servername = "northwoodhotel.xyz";
  $username = "cp018101";
  $password = PASSWORD;
  $database = "cp018101_nwh";

  if ($_SERVER['SERVER_NAME'] == $servername) {
    $db = mysqli_connect($servername, $username, $password, $database);
  } else {
    $db = mysqli_connect($_SERVER['SERVER_NAME'], "root", $password, $database);
  }
  if (!$db)
  {
    die("Connection failed: " . $db->connect_error);
  }
?>