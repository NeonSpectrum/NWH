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
    $expensesType = $system->filter_input($_POST['expensesType']);
    $quantity     = $system->filter_input($_POST['txtQuantity']);
    $result       = $db->query("SELECT * FROM expenses WHERE Name='$expensesType'");
    $expensesID   = $result->fetch_assoc()['ExpensesID'];
    if ($expensesType == "Others") {
      $db->query("INSERT INTO booking_expenses VALUES($bookingID, $expensesID, $quantity, $payment)");
    } else {
      $db->query("INSERT INTO booking_expenses VALUES($bookingID, $expensesID, $quantity, NULL)");
    }
    if ($db->affected_rows > 0) {
      $system->log("insert|booking.payment|{$system->formatBookingID($bookingID)}|$payment");
    }
  }
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>