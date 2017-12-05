<?php
  session_start();
  require_once '../files/db.php';
  
  if (isset($_POST)) {
    $room = $_POST['rdbRoom'];
    echo getRoomPrice($room);
  }
?>