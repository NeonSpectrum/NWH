<?php
session_start();
require_once '../files/db.php';

$name          = $_SESSION['fname'] . $_SESSION['lname'];
$email         = $_SESSION['email'];
$host          = strpos($_SERVER['PHP_SELF'], "nwh") ? "/nwh" : "";
$target_dir    = $_SERVER['DOCUMENT_ROOT'] . "$host/images/profilepics/";
$target_file   = basename($_FILES["file"]["name"]);
$imageFileType = pathinfo($target_dir . $target_file, PATHINFO_EXTENSION);
$target_file   = basename($name) . "." . $imageFileType;

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir . $target_file)) {
  $db->query("UPDATE account SET ProfilePicture='$target_file' WHERE EmailAddress='$email'");
  createLog("update|account.profilepic");
  $_SESSION["picture"] = $target_file;
  echo true;
} else {
  echo UPLOAD_ERROR;
}
?>