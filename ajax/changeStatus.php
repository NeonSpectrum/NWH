<?php
session_start();
require_once '../files/db.php';

if (isset($_POST)) {
  try {
    $query  = "UPDATE room SET Status = '{$_POST['status']}' WHERE RoomID = {$_POST['roomID']}";
    $result = mysqli_query($db, $query) or die(mysql_error());
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
?>