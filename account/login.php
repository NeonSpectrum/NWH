<?php
session_start();
require_once '../files/db.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $email    = $db->real_escape_string($_POST['txtEmail']);
  $password = $db->real_escape_string($_POST['txtPassword']);
  $result   = $db->query("SELECT * FROM `account` WHERE EmailAddress='$email'");
  $row      = $result->fetch_assoc();
  if ($result->num_rows == 1 && password_verify($password, $row['Password']) && strpos($email, '@') && strpos($email, '.')) {
    createLog("login|account", $email);
    $_SESSION['email']         = $row['EmailAddress'];
    $_SESSION['fname']         = $row['FirstName'];
    $_SESSION['lname']         = $row['LastName'];
    $_SESSION['picture']       = $row['ProfilePicture'];
    $_SESSION['accountType']   = $row['AccountType'];
    $_SESSION['birthDate']     = $row['BirthDate'];
    $_SESSION['contactNumber'] = $row['ContactNumber'];
    // update isLogged
    $cookie = nwh_encrypt("email=" . $email . "&password=" . $row['Password']);
    // if(!empty($_POST["cbxRemember"]))
    // {
    // setcookie("nwhAuth", $cookie, time() + (60 * 60 * 24 * 7), "/");
    // }
    // else
    // {
    //   if(isset($_COOKIE["nwhAuth"]))
    //   {
    //     setcookie ('nwhAuth', '', time() - (60 * 60 * 24 * 7),'/');
    //     unset($_COOKIE['nwhAuth']);
    //   }
    // }
    $db->query("UPDATE account SET SessionID='" . session_id() . "' WHERE EmailAddress='$email'");
    echo true;
  } else {
    echo INVALID_EMAIL_PASSWORD;
  }
}
?>