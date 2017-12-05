<?php
  session_start();
  require_once '../files/db.php';
  
  if (isset($_POST)) {
    $roomType = $_POST['txtRoomType'];
    $roomDescription = $_POST['txtDescription'];

    $query = "UPDATE room_type SET RoomDescription='$roomDescription' WHERE RoomType='$roomType'";
    mysqli_query($db, $query);
    
    if (mysqli_affected_rows($db) > 0) {
      echo true;
    }
  }
?>