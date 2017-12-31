<?php
@session_start();
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $bookingID = $system->filter_input($_POST['cmbBookingID']);

  $book->showBookingInfo($bookingID);
}
?>