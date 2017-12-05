<?php
  // Pear Mail Library
  $domain = strpos($_SERVER['REQUEST_URI'],"nwh") ? "{$_SERVER['SERVER_NAME']}/nwh" : $_SERVER['SERVER_NAME'];

  require_once '../files/db.php';

  parse_str(nwh_decrypt($_SERVER['QUERY_STRING']));

  if (isset($newPass)) {
    $newPass = password_hash($newPass, PASSWORD_DEFAULT);
    $query = "UPDATE account SET Password='$newPass' WHERE EmailAddress='$email'";
    $result = mysqli_query($db,$query) or die(mysql_error());
    if (mysqli_affected_rows($db) > 0) {
      echo '<script>alert("Reset Successfully!");location.href="../";</script>';
      exit();
    } else {
      echo ERROR_OCCURED;
    }
  } else if(isset($_POST)) {
    $email = stripslashes($_POST['txtEmail']); // removes backslashes
    $email = mysqli_real_escape_string($db,$email); //escapes special characters in a string
    $query = "SELECT * FROM `account` WHERE EmailAddress='$email'";
    $result = mysqli_query($db,$query) or die(mysql_error());
    $row = $result->fetch_assoc();
    $count = mysqli_num_rows($result);
    if($count==1 && strpos($email,'@') && strpos($email,'.')) {
      $randomNumber = mt_rand(10000000, 99999999);
      $data = nwh_encrypt("email=$email&newPass=$randomNumber");
      $subject = "Northwood Hotel Forgot Password";
      $body = "Please proceed to this link to reset your password:<br/>http://$domain/files/checkForgot.php?$data<br/><br/>Your new password will be: <b>$randomNumber</b>";
      
      echo sendMail("$email","$subject","$body");
    } elseif(!strpos($email, '@') || !strpos($email, '.')) {
      echo FORMAT_ERROR_EMAIL;
    } else {
      echo INVALID_EMAIL;
    }
  }
?>