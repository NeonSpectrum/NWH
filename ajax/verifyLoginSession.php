<?php
@session_start();
require_once '../files/autoload.php';
if (isset($_SESSION['account'])) {
  $result = $db->query("SELECT * FROM `account` WHERE EmailAddress='{$system->decrypt($_SESSION['account'])}'");
  $row    = $result->fetch_assoc();

  if (session_id() != $row['SessionID']) {
    echo false;
  } else {
    echo true;
  }
}
?>