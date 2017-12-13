<?php
session_start();
require_once '../files/db.php';

if (isset($_POST)) {
  try {
    $email         = $_SESSION['email'];
    $fname         = $_POST['txtFirstName'];
    $lname         = $_POST['txtLastName'];
    $birthDate     = $_POST['txtBirthDate'];
    $contactNumber = $_POST['txtContactNumber'];
    $query         = "UPDATE account SET FirstName='$fname', LastName='$lname', BirthDate='$birthDate', ContactNumber='$contactNumber' WHERE EmailAddress='$email'";
    $result        = mysqli_query($db, $query) or die(mysql_error());
    if (mysqli_affected_rows($db) > 0 || ($_POST['profilePic'] == 1 && mysqli_affected_rows($db) == 0)) {
      $_SESSION['fname']         = $fname;
      $_SESSION['lname']         = $lname;
      $_SESSION['birthDate']     = $birthDate;
      $_SESSION['contactNumber'] = $contactNumber;
      echo true;
    } else {
      echo NO_UPDATE;
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
?>