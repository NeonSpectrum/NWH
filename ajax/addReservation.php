<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $roomType     = $system->filter_input(str_replace(" ", "_", $_POST['cmbRoomType']));
  $email        = $system->filter_input($_POST['txtEmail']);
  $checkInDate  = $system->filter_input($_POST['txtCheckInDate']);
  $checkOutDate = $system->filter_input($_POST['txtCheckOutDate']);
  $adults       = $system->filter_input($_POST['txtAdults']);
  $children     = $system->filter_input($_POST['txtChildren']);
  $roomID       = $room->generateRoomID($roomType);
  $price        = $room->getRoomPrice($roomType);

  $db->query("INSERT INTO `walk-in` VALUES(NULL, '$email', $roomID, '$checkInDate', '$checkOutDate', $adults, $children, 0, $price)");

  if ($db->affected_rows > 0) {
    createLog("insert|walk-in|" . $db->insert_id);
    echo true;
  }
}
?>