<?php
session_start();
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $bookingID = $db->real_escape_string($_POST['cmbBookingID']);

  $book->showBookingInfo($bookingID);
}
?>