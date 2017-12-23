<?php
session_start();
require_once '../files/db.php';
if (isset($_SESSION['email'])) {
  $result = $db->query("SELECT * FROM `account` WHERE EmailAddress='{$_SESSION['email']}'");
  $row    = $result->fetch_assoc();
  if (session_id() != $row['SessionID'] && $row['AccountType'] != "Owner") {
    echo false;
    return;
  }
}
echo true;
?>