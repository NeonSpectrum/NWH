<?php
require_once '../files/autoload.php';

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  parse_str($system->decrypt($_GET['data']), $data);
  if ($_GET['type'] == 'success' && isset($_GET['paymentId'])) {
    echo "<script src='../assets/js/required/socket.io.js'></script>";
    echo "<script src='../assets/js/core.php'></script>";
    if (!$system->validateToken($_GET['csrf_token'])) {
      echo "<script>alert('Token was invalid');location.href='$root';</script>";
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
      echo "<script>alert('Something went wrong! Please try again.');location.href='$root';</script>";
      return;
    }
    $bookingID = $data['txtBookingID'];
    $payerID   = $system->filter_input($_GET['PayerID']);
    $paymentID = $system->filter_input($_GET['paymentId']);
    $token     = $system->filter_input($_GET['token']);
    $amount    = $system->filter_input($data['txtAmount']);
    $db->query("INSERT INTO booking_paypal VALUES($bookingID,'$payerID','$paymentID','{$transactions[0]->invoice_number}','$token',$amount,'$dateandtime')");
    if ($db->affected_rows > 0) {
      $db->query("UPDATE booking_transaction SET AmountPaid=AmountPaid+$amount WHERE BookingID=$bookingID");
      $system->log("insert|payment.paypal.success|$bookingID|₱&nbsp;" . number_format($amount));
      ?>
    <script>
      socket.emit('notification',{
        user: email_address,
        type: 'book',
        messages: "Paid from PayPal<br/>Booking ID: <a href='<?php echo $root; ?>admin/reports/listofpaypalpayment/?search=<?php echo $system->formatBookingID($bookingID); ?>'><?php echo $system->formatBookingID($bookingID); ?></a>"
      });
      alert("<?php echo PAYMENT_SUCCESS; ?>");
      location.href='<?php echo $root; ?>';
    </script>
<?php
} else {
      echo "<script>alert('" . ALREADY_PAID . "');location.href='$root';</script>";
    }
  } else {
    $system->log("notify|payment.paypal.cancelled|$bookingID");
    echo "<script>alert('" . PAYMENT_CANCELLED . "');location.href='$root';</script>";
  }
}
?>