<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID    = $system->filter_input($_POST['cmbBookingID']);
  $roomType     = $system->filter_input(str_replace(" ", "_", $_POST['cmbRoomType']));
  $roomID       = $system->filter_input(generateRoomID($roomType));
  $checkInDate  = $system->filter_input($_POST['txtCheckInDate']);
  $checkOutDate = $system->filter_input($_POST['txtCheckOutDate']);
  $adults       = $system->filter_input($_POST['txtAdults']);
  $children     = $system->filter_input($_POST['txtChildren']);

  $result = $db->query("UPDATE booking SET RoomID=$roomID,CheckInDate='$checkInDate',CheckOutDate='$checkOutDate',Adults=$adults,Children=$children WHERE BookingID=$bookingID");

  if ($db->affected_rows > 0) {
    createLog("update|booking|$bookingID");
    echo true;
  } else {
    echo $db->error;
  }
}
?>