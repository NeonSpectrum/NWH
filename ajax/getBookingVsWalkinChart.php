<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $booking = (int) $db->query("
    SELECT COUNT(*) as total FROM booking WHERE type='reservation'
  ")->fetch_assoc()['total'];
  $walkin = (int) $db->query("
    SELECT COUNT(*) as total FROM booking WHERE type='walkin'
  ")->fetch_assoc()['total'];

  echo json_encode([$booking, $walkin]);
}
?>
