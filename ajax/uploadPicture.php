<?php
@session_start();
require_once '../files/autoload.php';

$name  = $account->firstName . $account->lastName;
$email = $system->decrypt($_SESSION['account']);

$target_dir    = $_SERVER['DOCUMENT_ROOT'] . "{$root}images/profilepics/";
$target_file   = basename($_FILES["file"]["name"]);
$imageFileType = pathinfo($target_dir . $target_file, PATHINFO_EXTENSION);
$target_file   = basename($name) . "." . strtolower($imageFileType);

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir . $target_file)) {
  $db->query("UPDATE account SET ProfilePicture='$target_file' WHERE EmailAddress='$email'");
  log("update|account.profilepic");
  $_SESSION["picture"] = $target_file;
  echo true;
} else {
  echo UPLOAD_ERROR;
}
?>