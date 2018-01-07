<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  if ($_POST['type'] == "checkIn") {
    $db->query("INSERT INTO booking_check VALUES(NULL, $bookingID, '$dateandtime', NULL, 0)");
    if ($db->affected_rows > 0) {
      $system->log("insert|walk-in|$bookingID|checkin");
      echo true;
    } else {
      echo $db->error;
    }
  } else if ($_POST['type'] == "checkOut") {
    $db->query("UPDATE booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID SET CheckOut='$dateandtime' WHERE booking_check.BookingID=$bookingID");
    if ($db->affected_rows > 0) {
      $system->log("update|walk-in|$bookingID|checkout");
      echo true;
    } else {
      echo $db->error;
    }
  }

}
?>