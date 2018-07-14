<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $roomID   = $system->filter_input($_POST['txtRoomID']);
  $roomType = $system->filter_input($_POST['cmbRoomType']);

  echo $room->addRoomID($roomID, $roomType);
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>