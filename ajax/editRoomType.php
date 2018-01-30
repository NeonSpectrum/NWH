<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $roomDetails[] = $system->filter_input($_POST['txtRoomType']);
  $roomDetails[] = $system->filter_input($_POST['txtDescription']);
  $roomDetails[] = $system->filter_input($_POST['txtRoomSimpDesc']);
  $roomDetails[] = $system->filter_input($_POST['txtIcon']);
  $roomDetails[] = $system->filter_input($_POST['txtCapacity']);
  $roomDetails[] = $system->filter_input($_POST['txtRegularRate']);
  $roomDetails[] = $system->filter_input($_POST['txtSeasonRate']);
  $roomDetails[] = $system->filter_input($_POST['txtHolidayRate']);

  echo $room->editRoomType($roomDetails);
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>