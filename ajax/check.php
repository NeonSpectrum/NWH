<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  if ($_POST['type'] == "checkIn") {
    $result = $db->query("SELECT * FROM booking_check WHERE BookingID=$bookingID");
    if ($result->num_rows > 0) {
      $db->query("UPDATE booking_check SET CheckIn='$dateandtime' WHERE BookingID=$bookingID");
    } else {
      $db->query("INSERT INTO booking_check VALUES($bookingID, '$dateandtime', NULL)");
    }
    if ($db->affected_rows > 0) {
      $system->log("insert|{$system->formatBookingID($bookingID)}|checkin");
      echo true;
    } else {
      echo $db->error;
    }
  } else if ($_POST['type'] == "checkOut") {
    $db->query("UPDATE room JOIN booking_room ON room.RoomID=booking_room.RoomID SET Cleaning=1 WHERE BookingID=$bookingID");
    $db->query("UPDATE booking JOIN booking_check ON booking.BookingID=booking_check.BookingID SET CheckOut='$dateandtime' WHERE booking.BookingID=$bookingID");
    if ($db->affected_rows > 0) {
      $system->log("update|{$system->formatBookingID($bookingID)}|checkout");
      echo true;
    } else {
      echo $db->error;
    }
  }
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>