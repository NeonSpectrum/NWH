<?php
require_once "../../files/autoload.php";

$result = $db->query("SELECT * FROM account WHERE EmailAddress='{$_GET['email']}'");
$row    = $result->fetch_assoc();
if ($row['EmailAddress'] == $account->email) {
  $filename = file_exists($row['ProfilePicture']) ? $row['ProfilePicture'] : "default";
  $imginfo  = getimagesize($filename);
  header("Content-type: {$imginfo['mime']}");
  readfile($filename);
} else {
  echo NO_PERMISSION;
}
?>