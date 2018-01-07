<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  $payment   = $system->filter_input($_POST['txtPayment']);
  if ($_POST['type'] == "booking") {
    $db->query("UPDATE booking SET AmountPaid = AmountPaid + $payment WHERE BookingID = $bookingID");
    if ($db->affected_rows > 0) {
      $system->log("insert|booking.payment|$bookingID|$payment");
    }
  } else if ($_POST['type'] == "check") {
    $db->query("UPDATE booking_check SET ExtraCharges = ExtraCharges + $payment WHERE BookingID = $bookingID");
    if ($db->affected_rows > 0) {
      $system->log("insert|booking.payment|$bookingID|$payment");
    }
  }
}
?>