<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  $payment   = $system->filter_input(str_replace(',', '', $_POST['txtPayment']));
  if ($_POST['type'] == 'booking') {
    $db->query("UPDATE booking_transaction SET AmountPaid = AmountPaid + $payment WHERE BookingID = $bookingID");
    if ($db->affected_rows > 0) {
      $system->log("insert|booking.payment|$bookingID|$payment");
    }
  } else if ($_POST['type'] == 'check') {
    $expensesType = $system->filter_input($_POST['expensesType']);
    $quantity     = $system->filter_input($_POST['txtQuantity']);
    $remark       = $system->filter_input($_POST['txtRemark']);
    $result       = $db->query("SELECT * FROM expenses WHERE Name='$expensesType'");
    $expensesID   = $result->fetch_assoc()['ExpensesID'];
    if ($expensesType == 'Others') {
      $db->query("INSERT INTO booking_expenses VALUES($bookingID, $expensesID, $quantity, $payment, '$remark')");
    } else {
      $db->query("INSERT INTO booking_expenses VALUES($bookingID, $expensesID, $quantity, NULL, '$remark')");
    }
    if ($db->affected_rows > 0) {
      $system->log("insert|booking.expenses|{$system->formatBookingID($bookingID)}|{$_POST['expensesType']}|$quantity|₱" . number_format($payment, 2, '.', ','));
    }
  }
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>
