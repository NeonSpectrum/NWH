<?php
require_once "../../files/autoload.php";

$result = $db->query("SELECT * FROM booking_bank JOIN booking ON booking_bank.BookingID=booking.BookingID JOIN account ON booking.EmailAddress=account.EmailAddress WHERE booking.BookingID={$system->formatBookingID($_GET['id'], true)}");
$row    = $result->fetch_assoc();
if ($row['EmailAddress'] == $account->email || $system->checkUserLevel(1)) {
  $filename = file_exists($row['Filename']) ? $row['Filename'] : "default";
  $imginfo  = getimagesize($filename);
  header("Content-type: {$imginfo['mime']}");
  readfile($filename);
} else {
  echo NO_PERMISSION;
}
?>