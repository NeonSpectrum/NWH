<?php
require_once '../files/autoload.php';

use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

parse_str($system->decrypt($_SERVER['QUERY_STRING']), $query);

$price     = $query['txtAmount'];
$bookingID = $query['txtBookingID'];
$data      = $system->encrypt("txtAmount=$price&txtBookingID=$bookingID&csrf_token={$query['csrf_token']}");
$rooms     = json_decode($query['rooms'], true);

$payer = new Payer();
$payer->setPaymentMethod('paypal');
for ($i = 0; $i < count($rooms); $i++) {
  $item[$i] = new Item();
  $item[$i]->setName($rooms[$i]['roomType'])
    ->setCurrency('PHP')
    ->setQuantity($rooms[$i]['roomQuantity'])
    ->setPrice($room->getRoomPrice($rooms[$i]['roomType']));
}

$itemList = new ItemList();
$itemList->setItems($item);

$amount = new Amount();
$amount->setCurrency('PHP')
  ->setTotal($price);

$transaction = new Transaction();
$transaction->setAmount($amount)
  ->setItemList($itemList)
  ->setDescription("Test")
  ->setInvoiceNumber(uniqid());

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("http://{$_SERVER['SERVER_NAME']}{$root}payment?type=success&data=$data")
  ->setCancelUrl("http://{$_SERVER['SERVER_NAME']}{$root}payment?type=cancelled&data=$data");

$payment = new Payment();
$payment->setIntent('sale')
  ->setPayer($payer)
  ->setTransactions(array($transaction))
  ->setRedirectUrls($redirectUrls);

try {
  $payment->create($apiContext);
  header("Location: " . $payment->getApprovalLink());
} catch (Exception $ex) {
  echo "Error: " . $ex->getMessage();
}

?>