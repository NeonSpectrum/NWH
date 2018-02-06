<?php
require_once "../../files/autoload.php";

$result = $db->query("SELECT * FROM booking_bank JOIN booking ON booking_bank.BookingID=booking.BookingID JOIN account ON booking.EmailAddress=account.EmailAddress WHERE booking.BookingID={$system->formatBookingID($_GET['id'], true)}");
$row    = $result->fetch_assoc();
if ($result->num_rows > 0 && ($row['EmailAddress'] == $account->email || $system->checkUserLevel(1))) {
  $filename = file_exists($row['Filename']) ? $row['Filename'] : "default";
  $imginfo  = getimagesize($filename);
  header("Content-type: {$imginfo['mime']}");
  readfile($filename);
} else if ($result->num_rows == 0) {
  header("Content-type: image/gif");
  echo base64_decode("R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7");
} else {
  echo NO_PERMISSION;
}
?>