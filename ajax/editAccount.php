<?php
session_start();
require_once '../files/db.php';

if (isset($_POST)) {
  try {
    $email       = $_POST['txtEmail'];
    $accounttype = $_POST['cmbAccountType'];
    $firstname   = $_POST['txtFirstName'];
    $lastname    = $_POST['txtLastName'];

    $query  = "SELECT * FROM account WHERE EmailAddress='$email'";
    $result = mysqli_query($db, $query);
    $row    = $result->fetch_assoc();
    if ($_SESSION['accountType'] != 'Owner' && $row['AccountType'] == 'Owner') {
      echo PRIVILEGE_EDIT_ACCOUNT;
      return;
    }

    $query  = "UPDATE `account` SET AccountType='$accounttype',Firstname='$firstname',Lastname='$lastname' WHERE EmailAddress='$email'";
    $result = mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
      echo true;
    } else {
      echo NO_UPDATE;
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
?>