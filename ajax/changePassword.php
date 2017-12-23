<?php
session_start();
require_once '../files/db.php';

$pass  = $_POST['txtNewPass'];
$rpass = $_POST['txtRetypeNewPass'];
if ($pass != $rpass) {
  echo VERIFY_PASSWORD_ERROR;
  return;
}
if (isset($_POST)) {
  $email    = $db->real_escape_string($_SESSION['email']);
  $password = $db->real_escape_string($_POST['txtOldPass']);
  $newpass  = $db->real_escape_string($_POST['txtNewPass']);
  $newpass  = password_hash($newpass, PASSWORD_DEFAULT);
  $result   = $db->query("SELECT * FROM `account` WHERE EmailAddress='$email'");
  $row      = $result->fetch_assoc();
  if ($result->num_rows == 1 && password_verify($password, $row['Password'])) {
    $result = $db->query("UPDATE account SET Password='$newpass' WHERE EmailAddress='$email'");
    if ($db->affected_rows > 0) {
      createLog("update|user.password");
      echo true;
    } else {
      echo $db->error;
    }
  } else {
    echo OLD_PASSWORD_ERROR;
  }
}
?>