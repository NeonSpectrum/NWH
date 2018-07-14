<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $roomType = $system->filter_input($_POST['txtRoomType']);

  echo $room->deleteRoomType($roomType);
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>