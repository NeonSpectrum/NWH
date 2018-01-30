<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $roomID   = $system->filter_input($_POST['txtRoomID']);
  $roomType = $system->filter_input($_POST['cmbRoomType']);

  echo $room->editRoomID($roomID, $roomType);
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>