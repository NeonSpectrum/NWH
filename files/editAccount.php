<?php
  session_start();
  require_once 'db.php';
  if (isset($_POST)) {
    try {
      $email = $_POST['cmbEmail'];
      $accounttype = $_POST['cmbAccountType'];
      $query="SELECT * FROM account WHERE EmailAddress='$email'";
      $result = mysqli_query($db,$query);
      $row = $result->fetch_assoc();
      if($_SESSION['accountType'] != 'Owner' && $row['AccountType']=='Owner') {
        echo PRIVILEGE_EDIT_ACCOUNT;
        return;
      }
      $profilepicture = $_POST['txtProfilePicture'];
      $firstname = $_POST['txtFirstName'];
      $lastname = $_POST['txtLastName'];
      $query = "UPDATE `account` SET AccountType='$accounttype',ProfilePicture='$profilepicture',Firstname='$firstname',Lastname='$lastname' WHERE EmailAddress='$email'";
      $result = mysqli_query($db,$query);
      if(mysqli_affected_rows($db)!=0) {
        echo "ok";
      } else {
        echo NO_UPDATE;
      }
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }
?>