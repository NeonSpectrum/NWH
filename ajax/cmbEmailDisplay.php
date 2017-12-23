<?php
session_start();
require_once '../files/db.php';

if (isset($_POST)) {
  $arr    = array();
  $email  = $db->real_escape_string($_POST['cmbEmail']);
  $result = $db->query("SELECT * FROM `account` WHERE EmailAddress='$email'");
  $row    = $result->fetch_assoc();
  if ($result->num_rows == 1) {
    $arr[0] = $row['AccountType'];
    $arr[1] = $row['FirstName'];
    $arr[2] = $row['LastName'];

    echo json_encode($arr);
  } else {
    $arr[0] = $db->error;
    echo json_encode($arr);
  }
}
?>