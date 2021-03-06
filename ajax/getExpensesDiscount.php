<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $name = $system->filter_input($_POST['txtName']);
  if ($_POST['type'] == 'Discount') {
    $row = $db->query("SELECT * FROM discount WHERE Name='$name'")->fetch_assoc();
    echo json_encode([
      'amount'  => $row['Amount'],
      'taxFree' => (int) $row['TaxFree']
    ]);
  } else if ($_POST['type'] == 'Expenses') {
    $result = $db->query("SELECT * FROM expenses WHERE Name='$name'")->fetch_assoc();
    echo json_encode([
      'amount' => (int) $row['Amount']
    ]);
  }
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>
