<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $db->query("DELETE FROM booking_room");
  $db->query("DELETE FROM booking_paypal");
  $db->query("DELETE FROM booking_cancelled");
  $db->query("DELETE FROM booking_check");
  $db->query("DELETE FROM booking");
  echo $db->affected_rows;
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>