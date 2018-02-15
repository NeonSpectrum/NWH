<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $name = $system->filter_input($_POST['txtName']);
  if ($_POST['type'] == "Discount") {
    echo $system->deleteDiscount($name);
  } else if ($_POST['type'] == "Expenses") {
    echo $system->deleteExpenses($name);
  }
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>