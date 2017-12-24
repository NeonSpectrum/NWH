<?php
require_once '../files/db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $bookingID    = $db->real_escape_string($_POST['cmbBookingID']);
  $roomType     = $db->real_escape_string(str_replace(" ", "_", $_POST['cmbRoomType']));
  $roomID       = $db->real_escape_string(generateRoomID($roomType));
  $checkInDate  = $db->real_escape_string($_POST['txtCheckInDate']);
  $checkOutDate = $db->real_escape_string($_POST['txtCheckOutDate']);
  $adults       = $db->real_escape_string($_POST['txtAdults']);
  $children     = $db->real_escape_string($_POST['txtChildren']);

  $result = $db->query("UPDATE booking SET RoomID=$roomID,CheckInDate='$checkInDate',CheckOutDate='$checkOutDate',Adults=$adults,Children=$children WHERE BookingID=$bookingID");

  if ($db->affected_rows > 0) {
    createLog("update|booking|$bookingID");
    echo true;
  } else {
    echo $db->error;
  }
}
?>