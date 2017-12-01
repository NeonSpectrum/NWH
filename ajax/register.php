<?php
  // Pear Mail Library
  $domain = strpos($_SERVER['REQUEST_URI'],"nwh") ? "{$_SERVER['SERVER_NAME']}/nwh" : $_SERVER['SERVER_NAME'];
  require_once '../files/db.php';

  parse_str(nwh_decrypt($_SERVER['QUERY_STRING']));

  if(isset($txtEmail))
  {
    $fname = $txtFirstName;
    $lname = $txtLastName;
    $email = $txtEmail;
    $password = $txtPassword;
    $date = date("Y-m-d");
    $query = "INSERT INTO `account`(EmailAddress,Password,FirstName,LastName,DateRegistered) VALUES ('$email', '$password', '$fname', '$lname','$date')";
    $result = mysqli_query($db,$query);
    $host = strpos($_SERVER['REQUEST_URI'],"nwh") ? "/nwh" : "/";
    if(!$result)
    {
      echo "<script>alert('Already Registered!');location.href='$host';</script>";
    }
    else if(mysqli_affected_rows($db)!=0)
    {
      echo "<script>alert('Registered Successfully!');location.href='$host';</script>";
    }
  }
  else if(isset($_POST))
  {
    $fname = stripslashes($_POST['txtFirstName']); // removes backslashes
    $fname = mysqli_real_escape_string($db,$fname); //escapes special characters in a string
    $fname = ucwords($fname); //capitalize first character
    $lname = stripslashes($_POST['txtLastName']); // removes backslashes
    $lname = mysqli_real_escape_string($db,$lname); //escapes special characters in a string
    $lname = ucwords($lname); //capitalize first character
    $email = stripslashes($_POST['txtEmail']);
    $email = mysqli_real_escape_string($db,$email);
    $password = stripslashes($_POST['txtPassword']);
    $password = mysqli_real_escape_string($db,$password);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "SELECT * FROM account WHERE EmailAddress='$email'";
    $result = mysqli_query($db,$query);
    $count = mysqli_num_rows($result);

    if ($count == 0 && strpos($email,'@') && strpos($email,'.')) {
      $data = nwh_encrypt("txtFirstName=$fname&txtLastName=$lname&txtEmail=$email&txtPassword=$password");
      $subject = "Northwood Hotel Account Creation";
      $body = "Please proceed to this link to register your account:<br/>http://$domain/ajax/register.php?$data";
      echo sendMail("$email","$subject","$body");
    } else if($count != 0) {
      echo ALREADY_REGISTERED;
    } else {
      echo FORMAT_ERROR_EMAIL;
    }
  }
?>