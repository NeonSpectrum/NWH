<?php
session_start();
require_once '../files/db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $result = $db->query("UPDATE room SET Status = '{$_POST['status']}' WHERE RoomID = {$_POST['roomID']}");

  if ($db->affected_rows > 0) {
    createLog("update|room.status|{$_POST['roomID']}|{$_POST['status']}");
    echo true;
  } else {
    echo $db->error;
  }
}
?>