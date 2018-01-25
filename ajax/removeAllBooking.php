<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $tables = ["booking_room", "booking_check", "booking_paypal", "booking_cancelled", "booking"];
  $system->backupdb($tables, "all");
  foreach ($tables as $table) {
    $db->query("DELETE FROM $table");
  }
  echo $db->affected_rows;
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>