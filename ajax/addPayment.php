<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  $payment   = $system->filter_input($_POST['txtPayment']);
  $db->query("UPDATE booking SET AmountPaid = AmountPaid + $payment WHERE BookingID = $bookingID");
  if ($db->affected_rows > 0) {
    $system->log("insert|booking.payment|$bookingID|$payment");
  }
}
?>