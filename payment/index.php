<?php
require_once "../files/autoload.php";

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  parse_str($system->decrypt($_GET['data']), $data);
  if ($_GET['type'] == "success" && isset($_GET['paymentId'])) {
    if (!$system->validateToken($data['csrf_token'])) {
      echo "<script>alert('Token was invalid');location.href='../';</script>";
      exit();
    }
    $paymentId = $_GET['paymentId'];
    try {
      $payment      = Payment::get($paymentId, $apiContext);
      $transactions = $payment->getTransactions();
      $execution    = new PaymentExecution();
      $execution->setPayerId($_GET['PayerID']);
      $payment->execute($execution, $apiContext);
    } catch (\Exception $e) {
      print_r($e);
      return;
    }
    $bookingID = (int) substr($data['txtBookingID'], -4);
    $payerID   = $system->filter_input($_GET['PayerID']);
    $paymentID = $system->filter_input($_GET['paymentId']);
    $token     = $system->filter_input($_GET['token']);
    $amount    = $system->filter_input($data['txtAmount']);
    $db->query("INSERT INTO booking_paypal VALUES($bookingID,'$payerID','$paymentID','{$transactions[0]->invoice_number}','$token',$amount,'$dateandtime')");
    if ($db->affected_rows > 0) {
      $system->log("insert|payment.paypal.success|$bookingID|₱&nbsp;" . number_format($amount));
      echo "<script>alert('Payment Successfully Added!');location.href='../';</script>";
    } else {
      echo "<script>alert('Already Paid!');location.href='../';</script>";
    }
  } else {
    $system->log("notify|payment.paypal.cancelled|$bookingID");
    echo "<script>alert('Payment has been cancelled');location.href='../';</script>";
  }
}
?>