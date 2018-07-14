<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $roomID = $system->filter_input($_POST['roomID']);
  echo $room->cleanRoom($roomID);
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>