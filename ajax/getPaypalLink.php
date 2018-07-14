<?php
@session_start();
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  $db->query("UPDATE booking SET PaymentMethod='PayPal' WHERE BookingID=$bookingID");
  $result = $db->query("SELECT * FROM booking_paypal WHERE BookingID=$bookingID");
  if ($result->num_rows == 0) {
    echo "//{$_SERVER['SERVER_NAME']}{$root}payment/process.php/?" . $system->encrypt("txtBookingID=$bookingID&csrf_token={$_SERVER['HTTP_X_CSRF_TOKEN']}");
  } else {
    echo false;
  }
}
?>