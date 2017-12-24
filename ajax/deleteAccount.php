<?php
require_once '../files/db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $email = $db->real_escape_string($_POST['txtEmail']);

  $result = $db->query("DELETE FROM account WHERE EmailAddress='$email'");

  if ($db->affected_rows > 0) {
    createLog("delete|account|$email");
    echo true;
  } else {
    echo $db->error;
  }
}
?>