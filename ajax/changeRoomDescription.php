<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $roomType        = $db->real_escape_string($_POST['txtRoomType']);
  $roomDescription = $db->real_escape_string($_POST['txtDescription']);

  echo $room->editRoomDescription($roomType, $roomDescription);
}
?>