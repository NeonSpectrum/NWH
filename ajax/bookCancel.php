<?php
@session_start();
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  if ($_POST['mode'] == "cancel") {
    $db->query("INSERT INTO booking_cancelled VALUES($bookingID,'$date')");
    if ($db->affected_rows > 0) {
      $system->log("insert|booking|cancelled|$bookingID");
      echo true;
    } else {
      echo $db->error;
    }
  } else if ($_POST['mode'] == "revert") {
    $db->query("DELETE FROM booking_cancelled WHERE BookingID=$bookingID");
    if ($db->affected_rows > 0) {
      $system->log("delete|booking|cancelled|$bookingID");
      echo true;
    } else {
      echo $db->error;
    }
  }
}
?>