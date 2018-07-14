<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $roomID = $system->filter_input($_POST['txtRoomID']);

  echo $room->deleteRoomID($roomID);
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>