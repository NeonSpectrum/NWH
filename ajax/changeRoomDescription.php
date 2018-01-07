<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $roomType        = $system->filter_input($_POST['txtRoomType']);
  $roomDescription = $system->filter_input($_POST['txtDescription']);
  $roomSimpDesc    = $system->filter_input($_POST['txtRoomSimpDesc']);
  $icon            = $system->filter_input($_POST['txtIcon']);

  echo $room->editRoomDescription($roomType, $roomDescription, $roomSimpDesc, $icon);
}
?>