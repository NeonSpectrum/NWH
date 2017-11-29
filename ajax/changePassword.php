<?php
  session_start();
  require_once '../files/db.php';

  $pass = $_POST['txtNewPass'];
  $rpass = $_POST['txtRetypeNewPass'];
  if ($pass != $rpass) {
    echo VERIFY_PASSWORD_ERROR;
    return;
  }
  if (isset($_POST)) {
    try {
      $email = stripslashes($_SESSION['email']); // removes backslashes
      $email = mysqli_real_escape_string($db,$email); //escapes special characters in a string
      $password = stripslashes($_POST['txtOldPass']);
      $password = mysqli_real_escape_string($db,$password);
      $newpass = stripslashes($_POST['txtNewPass']);
      $newpass = mysqli_real_escape_string($db,$newpass);
      $newpass = password_hash($newpass, PASSWORD_DEFAULT);
      $query = "SELECT * FROM `account` WHERE EmailAddress='$email'";
      $result = mysqli_query($db,$query) or die(mysql_error());
      $row = $result->fetch_assoc();
      $count = mysqli_num_rows($result);
      if ($count==1 && password_verify($password, $row['Password']) && strpos($email,'@') && strpos($email,'.')) {
        $query = "UPDATE account SET Password='$newpass' WHERE EmailAddress='$email'";
        $result = mysqli_query($db,$query) or die(mysql_error());
        if (mysqli_affected_rows($db)!=0) {
          echo true;
        }
      } else {
        echo OLD_PASSWORD_ERROR;
      }
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }
?>