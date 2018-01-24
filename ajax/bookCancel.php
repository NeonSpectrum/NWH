<?php
@session_start();
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  $db->query("INSERT INTO booking_cancelled VALUES($bookingID,'$date')");
  if ($db->affected_rows > 0) {
    $system->log("insert|booking|cancelled|$bookingID");
    echo true;
  } else {
    echo $db->error;
  }
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>