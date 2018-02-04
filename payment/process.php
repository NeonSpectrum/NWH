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

$price          = 0;
$bookingID      = $query['txtBookingID'];
$roomIDs        = $room->getRoomIDList($bookingID);
$roomTypes      = $room->getRoomTypeList();
$roomQuantities = array_fill(0, count($roomTypes), 0);

for ($i = 0; $i < count($roomIDs); $i++) {
  $roomType = $room->getRoomType($roomIDs[$i]);
  $index    = array_search($roomType, $roomTypes);
  $roomQuantities[$index]++;
}

$payer = new Payer();
$payer->setPaymentMethod('paypal');
for ($i = 0, $j = 0; $i < count($roomTypes); $i++) {
  if ($roomQuantities[$i] == 0) {
    continue;
  }
  $item[$j] = new Item();
  $item[$j]->setName(str_replace("_", " ", $roomTypes[$i]))
    ->setCurrency('PHP')
    ->setQuantity($roomQuantities[$i])
    ->setPrice($room->getRoomPrice($roomTypes[$i]));
  $price += $room->getRoomPrice($roomTypes[$i]) * $roomQuantities[$i];
  $j++;
}

$item[$j] = new Item();
$item[$j]->setName("50% Down Payment")
  ->setCurrency('PHP')
  ->setQuantity(1)
  ->setPrice(-($price / 2));

$itemList = new ItemList();
$itemList->setItems($item);

$amount = new Amount();
$amount->setCurrency('PHP')
  ->setTotal($price / 2);

$transaction = new Transaction();
$transaction->setAmount($amount)
  ->setItemList($itemList)
  ->setDescription("Test")
  ->setInvoiceNumber(uniqid());

$data = $system->encrypt("txtAmount=" . ($price / 2) . "&txtBookingID=$bookingID&csrf_token={$query['csrf_token']}");

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
  // echo "Error: " . $ex->getMessage();
  echo print_r($ex->getData());
}

?>