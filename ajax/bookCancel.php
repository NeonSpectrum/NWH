<?php
@session_start();
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  $reason    = $system->filter_input($_POST['reason']);
  $result    = $db->query("SELECT * FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE booking.BookingID=$bookingID AND CheckIn IS NULL");
  if ($result->num_rows > 0) {
    $db->query("INSERT INTO booking_cancelled VALUES($bookingID,'$date','$reason')");
    if ($db->affected_rows > 0) {
      $system->log("insert|booking|cancelled|{$system->formatBookingID($bookingID)}");
      echo true;
    } else {
      echo $db->error;
    }
  } else {
    echo false;
  }
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>