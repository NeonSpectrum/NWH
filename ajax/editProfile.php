<?php
session_start();
require_once '../files/db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $email         = $db->real_escape_string($_SESSION['email']);
  $fname         = $db->real_escape_string($_POST['txtFirstName']);
  $lname         = $db->real_escape_string($_POST['txtLastName']);
  $birthDate     = $db->real_escape_string($_POST['txtBirthDate']);
  $contactNumber = $db->real_escape_string($_POST['txtContactNumber']);

  $result = $db->query("UPDATE account SET FirstName='$fname', LastName='$lname', BirthDate='$birthDate', ContactNumber='$contactNumber' WHERE EmailAddress='$email'");

  if ($db->affected_rows > 0 || ($_POST['profilePic'] == 1 && $db->affected_rows == 0)) {
    $_SESSION['fname']         = $fname;
    $_SESSION['lname']         = $lname;
    $_SESSION['birthDate']     = $birthDate;
    $_SESSION['contactNumber'] = $contactNumber;
    createLog("update|account.profile");
    echo true;
  } else {
    echo $db->error;
  }
}
?>