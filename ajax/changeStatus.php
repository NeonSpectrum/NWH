<?php
session_start();
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  echo $room->updateRoomStatus($_POST['roomID'], $_POST['status']);
}
?>