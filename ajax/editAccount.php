<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $credentials                = [];
  $credentials['email']       = $system->filter_input($_POST['txtEmail']);
  $credentials['accountType'] = $system->filter_input($_POST['cmbAccountType']);
  // $credentials['firstName']   = $system->filter_input($_POST['txtFirstName']);
  // $credentials['lastName']    = $system->filter_input($_POST['txtLastName']);

  echo $account->editProfile($credentials, true);
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>