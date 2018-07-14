<?php
@session_start();
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  echo $room->updateRoomStatus($_POST['roomID'], $_POST['status'], $_POST['type']);
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>