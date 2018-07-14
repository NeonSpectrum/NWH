<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $tables = ['booking_room', 'booking_check', 'booking_paypal', 'booking_cancelled', 'booking_bank', 'booking_discount', 'booking_expenses', 'booking_transaction', 'booking'];
  $system->backupdb($tables, 'all');
  foreach ($tables as $table) {
    $db->query("DELETE FROM $table");
    $affected_rows = $db->affected_rows;
    $db->query("ALTER TABLE $table AUTO_INCREMENT = 1");
  }
  $system->log("delete|AllBooking|$affected_rows");
  echo $affected_rows;
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>