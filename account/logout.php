<?php
session_start();
require_once '../files/db.php';

$email = $_SESSION['email'];
createLog("logout|account");
if (isSet($_COOKIE['nwhAuth'])) {
  setcookie('nwhAuth', '', time() - (60 * 60 * 24 * 7), '/');
  unset($_COOKIE['nwhAuth']);
}
if (session_destroy()) {
  if (strpos($_SERVER['HTTP_REFERER'], "/reservation")) {
    header("location: ../");
  } else {
    header("location:" . $_SERVER['HTTP_REFERER']);
  }
}
?>