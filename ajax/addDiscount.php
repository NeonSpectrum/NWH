<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  $discount  = $system->filter_input($_POST['txtDiscount']);
  $db->query("UPDATE booking_check SET Discount = '$discount' WHERE BookingID = $bookingID");
  if ($db->affected_rows > 0) {
    $system->log("insert|booking.discount|$bookingID|$discount");
  }
}
?>