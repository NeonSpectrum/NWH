<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $name   = $system->filter_input($_POST['txtName']);
  $amount = $system->filter_input($_POST['txtAmount']);
  if ($_POST['type'] == 'Discount') {
    echo $system->addDiscount($name, $amount);
  } else if ($_POST['type'] == 'Expenses') {
    echo $system->addExpenses($name, $amount);
  }
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>