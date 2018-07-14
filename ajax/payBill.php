<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  $payment   = $system->filter_input($_POST['payment']);
  echo number_format($system->payBill($bookingID, $payment), 2, '.', ',');
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>