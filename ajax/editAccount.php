<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $email       = $db->real_escape_string($_POST['txtEmail']);
  $accounttype = $db->real_escape_string($_POST['cmbAccountType']);
  $firstname   = $db->real_escape_string($_POST['txtFirstName']);
  $lastname    = $db->real_escape_string($_POST['txtLastName']);

  $result = $db->query("SELECT * FROM account WHERE EmailAddress='$email'");
  $row    = $result->fetch_assoc();

  $result = $db->query("UPDATE `account` SET AccountType='$accounttype',Firstname='$firstname',Lastname='$lastname' WHERE EmailAddress='$email'");
  if ($db->affected_rows > 0) {
    createLog("update|account|$email");
    echo true;
  } else {
    echo $db->error;
  }
}
?>