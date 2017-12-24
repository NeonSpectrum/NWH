<?php
$domain = strpos($_SERVER['REQUEST_URI'], "nwh") ? "{$_SERVER['SERVER_NAME']}/nwh" : $_SERVER['SERVER_NAME'];
$host   = strpos($_SERVER['REQUEST_URI'], "nwh") ? "/nwh" : "/";
session_start();
require_once '../files/db.php';

parse_str(nwh_decrypt($_SERVER['QUERY_STRING']));
$date = date("Y-m-d");

if (isset($txtEmail)) {
  if ($expirydate < strtotime("now")) {
    echo "<script>alert('Link Expired. Please register again.');location.href='$host';</script>";
    exit();
  }
  $result = $db->query("INSERT INTO `account`(EmailAddress,Password,FirstName,LastName,ContactNumber,BirthDate,DateRegistered) VALUES ('$txtEmail', '$txtPassword', '$txtFirstName', '$txtLastName','$txtContactNumber','$txtBirthDate','$date')");
  if ($db->affected_rows > 0) {
    createLog("registered|account|$txtEmail");
    echo "<script>alert('Registered Successfully!');location.href='$host';</script>";
  } else {
    echo "<script>alert('Already Registered!');location.href='$host';</script>";
  }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (!isset($_POST['type'])) {
    $captcha = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : false;
    if (!$captcha) {
      echo 'Please check the the captcha form.';
      return;
    }
    $secretKey    = "6Ler0DUUAAAAABE_r5gAH7LhkRPAavkyNkUOOQZd";
    $ip           = $_SERVER['REMOTE_ADDR'];
    $response     = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
    $responseKeys = json_decode($response, true);
    if (intval($responseKeys["success"]) !== 1) {
      echo 'You are spammer ! Get the @$%K out';
      return;
    }
  }
  $fname         = ucwords(strtolower($db->real_escape_string($_POST['txtFirstName'])));
  $lname         = ucwords(strtolower($db->real_escape_string($_POST['txtLastName'])));
  $email         = $db->real_escape_string($_POST['txtEmail']);
  $password      = $db->real_escape_string($_POST['txtPassword']);
  $password      = password_hash($password, PASSWORD_DEFAULT);
  $contactNumber = $db->real_escape_string($_POST['txtContactNumber']);
  $birthDate     = $db->real_escape_string($_POST['txtBirthDate']);
  $result        = $db->query("SELECT * FROM account WHERE EmailAddress='$email'");
  if ($result->num_rows == 0) {
    if (isset($_POST['type']) && $_POST['type'] == "noverify") {
      $db->query("INSERT INTO `account`(EmailAddress,Password,FirstName,LastName,ContactNumber,DateRegistered) VALUES ('$email', '$password', '$fname', '$lname','$contactNumber','$date')");
      createLog("insert|account.register|$email", $_SESSION['email']);
      if ($db->affected_rows > 0) {
        echo true;
      } else {
        echo ALREADY_REGISTERED;
      }
    } else {
      $data    = nwh_encrypt("txtFirstName=$fname&txtLastName=$lname&txtEmail=$email&txtPassword=$password&txtContactNumber=$contactNumber&txtBirthDate=$birthDate&expirydate=" . (strtotime("now") + (60 * 10)));
      $subject = "Northwood Hotel Account Creation";
      $body    = "Please proceed to this link to register your account:<br/>http://$domain/account/register.php?$data";
      if (sendMail("$email", "$subject", "$body") == true) {
        createLog("sent|registration|$email");
        echo true;
      }
    }
  } else {
    echo ALREADY_REGISTERED;
  }
}
?>