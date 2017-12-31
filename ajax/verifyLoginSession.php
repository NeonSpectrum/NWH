<?php
@session_start();
require_once '../files/autoload.php';
if (isset($_SESSION['account']['email'])) {
  $result = $db->query("SELECT * FROM `account` WHERE EmailAddress='{$_SESSION['account']['email']}'");
  $row    = $result->fetch_assoc();

  if (session_id() != $row['SessionID'] && $row['AccountType'] != "Owner") {
    echo false;
    return;
  }
}
echo true;
?>