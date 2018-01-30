<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $affected_rows = 0;
  $tables        = ["booking_room", "booking_check", "booking_paypal", "booking_cancelled", "booking"];
  $system->backupdb($tables, "all");
  foreach ($tables as $table) {
    $db->query("ALTER TABLE $table AUTO_INCREMENT = 1");
    $db->query("DELETE FROM $table");
    $affected_rows += $db->affected_rows;
  }
  echo $affected_rows;
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>