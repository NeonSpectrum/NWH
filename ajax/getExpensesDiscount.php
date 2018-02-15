<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $name = $system->filter_input($_POST['txtName']);
  if ($_POST['type'] == "Discount") {
    echo $db->query("SELECT * FROM discount WHERE Name='$name'")->fetch_assoc()['Amount'];
  } else if ($_POST['type'] == "Expenses") {
    echo $db->query("SELECT * FROM expenses WHERE Name='$name'")->fetch_assoc()['Amount'];
  }
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>