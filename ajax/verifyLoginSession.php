<?php
@session_start();
require_once '../files/autoload.php';
if (isset($_SESSION['account'])) {
  $result = $db->query("SELECT * FROM `account` WHERE EmailAddress='{$_SESSION['account']['email']}'");
  $row    = $result->fetch_assoc();

  if (session_id() != $row['SessionID']) {
    echo false;
  } else {
    echo true;
  }
}
?>