<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  $payment   = $system->filter_input($_POST['payment']);
  echo number_format($system->payBill($bookingID, $payment), 2, ".", ",";);
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>