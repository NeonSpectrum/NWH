<?php
@session_start();
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  echo $account->updateAccountStatus($_POST['email'], $_POST['status']);
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>