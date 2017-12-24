<?php
session_start();
require_once '../files/db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $roomType        = $db->real_escape_string($_POST['txtRoomType']);
  $roomDescription = $db->real_escape_string($_POST['txtDescription']);

  $db->query("UPDATE room_type SET RoomDescription='$roomDescription' WHERE RoomType='$roomType'");

  if ($db->affected_rows > 0) {
    createLog("update|room_type|$roomType");
    echo true;
  } else {
    echo $db->error;
  }
}
?>