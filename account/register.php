<?php
  // Pear Mail Library
  $domain = strpos($_SERVER['REQUEST_URI'],"nwh") ? "{$_SERVER['SERVER_NAME']}/nwh" : $_SERVER['SERVER_NAME'];
  $host = strpos($_SERVER['REQUEST_URI'],"nwh") ? "/nwh" : "/";
  require_once '../files/db.php';

  parse_str(nwh_decrypt($_SERVER['QUERY_STRING']));
  $date = date("Y-m-d");

  if(isset($txtEmail))
  {
    if ($expirydate < strtotime("now")) {
      echo "<script>alert('Link Expired. Please register again.');location.href='$host';</script>";
      exit();
    }
    $fname = $txtFirstName;
    $lname = $txtLastName;
    $email = $txtEmail;
    $password = $txtPassword;
    $contactNumber = $txtContactNumber;
    $query = "INSERT INTO `account`(EmailAddress,Password,FirstName,LastName,ContactNumber,DateRegistered) VALUES ('$email', '$password', '$fname', '$lname','$contactNumber','$date')";
    $result = mysqli_query($db,$query);
    if(!$result)
    {
      echo "<script>alert('Already Registered!');location.href='$host';</script>";
    }
    else if(mysqli_affected_rows($db) > 0)
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
    $contactNumber = stripslashes($_POST['txtContactNumber']);
    $contactNumber = mysqli_real_escape_string($db,$contactNumber);
    $query = "SELECT * FROM account WHERE EmailAddress='$email'";
    $result = mysqli_query($db,$query);
    $count = mysqli_num_rows($result);
    if ($count == 0 && strpos($email,'@') && strpos($email,'.')) {
      if (isset($_POST['type']) && $_POST['type'] == "noverify") {
        $query = "INSERT INTO `account`(EmailAddress,Password,FirstName,LastName,ContactNumber,DateRegistered) VALUES ('$email', '$password', '$fname', '$lname','$contactNumber','$date')";
        mysqli_query($db,$query);
        if (mysqli_affected_rows($db) > 0) {
          echo true;
        } else {
          echo ALREADY_REGISTERED;
        }
      } else {
        $data = nwh_encrypt("txtFirstName=$fname&txtLastName=$lname&txtEmail=$email&txtPassword=$password&txtContactNumber=$contactNumber&expirydate=" . (strtotime("now") + (60*5)));
        $subject = "Northwood Hotel Account Creation";
        $body = "Please proceed to this link to register your account:<br/>http://$domain/account/register.php?$data";
        echo sendMail("$email","$subject","$body");
      }
    } else if($count != 0) {
      echo ALREADY_REGISTERED;
    } else {
      echo FORMAT_ERROR_EMAIL;
    }
  }
?>