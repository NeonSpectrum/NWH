<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  echo $system->revertCheck($bookingID, $_POST['type']);
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>