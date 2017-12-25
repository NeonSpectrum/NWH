<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $credentials                = [];
  $credentials['email']       = $db->real_escape_string($_POST['txtEmail']);
  $credentials['accountType'] = $db->real_escape_string($_POST['cmbAccountType']);
  $credentials['firstName']   = $db->real_escape_string($_POST['txtFirstName']);
  $credentials['lastName']    = $db->real_escape_string($_POST['txtLastName']);

  echo $account->editProfile($credentials, true);
}
?>