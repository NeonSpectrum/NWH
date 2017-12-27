<?php
@session_start();
require_once '../files/autoload.php';

if (isset($_POST['mode'])) {
  $credentials = [];
  switch ($_POST['mode']) {
  case "login":{
      if ($account->login(array('email' => $_POST['txtEmail'], 'password' => $_POST['txtPassword']))) {
        echo true;
      } else {
        echo INVALID_EMAIL_PASSWORD;
      }
      break;
    }
  case "register":{
      parse_str($system->nwh_decrypt($_SERVER['QUERY_STRING']), $credentials);
      if (isset($credentials['txtEmail'])) {
        echo $account->register($credentials);
      } else if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $credentials['txtFirstName']     = $_POST['txtFirstName'];
        $credentials['txtLastName']      = $_POST['txtLastName'];
        $credentials['txtEmail']         = $_POST['txtEmail'];
        $credentials['txtPassword']      = $_POST['txtPassword'];
        $credentials['txtContactNumber'] = $_POST['txtContactNumber'];
        $credentials['txtBirthDate']     = $_POST['txtBirthDate'];
        if ($_POST['verify'] == "false") {
          echo $account->register($credentials, false);
        } else {
          $captcha = $system->verifyCaptcha($_POST['g-recaptcha-response']);
          if ($captcha) {
            echo $account->verifyRegistration($credentials, true);
          } else {
            echo $captcha;
          }
        }
      }
      break;
    }
  case "changePassword":{
      $forgot                 = isset($_POST['txtEmail']) ? true : false;
      $email                  = isset($_SESSION['email']) ? $_SESSION['email'] : $_POST['txtEmail'];
      $credentials['email']   = $db->real_escape_string($email);
      $credentials['oldpass'] = $forgot ? null : $db->real_escape_string($_POST['txtOldPass']);
      $credentials['newpass'] = password_hash($db->real_escape_string($_POST['txtNewPass']), PASSWORD_DEFAULT);
      $credentials['token']   = isset($_POST['txtToken']) ? $db->real_escape_string($_POST['txtToken']) : null;

      if ($account->changePassword($credentials, $forgot) == true) {
        echo true;
      } else {
        echo OLD_PASSWORD_ERROR;
      }
      break;
    }
  case "forgotPassword":{
      $email = $db->real_escape_string($_POST['txtEmail']);
      if ($account->forgotPassword($email)) {
        echo true;
      } else {
        echo INVALID_EMAIL;
      }
      break;
    }
  case "deleteAccount":{
      $email = $db->real_escape_string($_POST['txtEmail']);
      echo $account->deleteAccount($email);
      break;
    }
  }
} else if (isset($_GET['mode'])) {
  switch ($_GET['mode']) {
  case "logout":{
      $account->logout();
      break;
    }
  case "checkEmail":{
      if ($account->checkEmail($_GET['txtEmail'])) {
        http_response_code(406);
      } else {
        http_response_code(200);
      }
      break;
    }
  case "editAccount":{
      $credentials['email']         = $db->real_escape_string($_SESSION['email']);
      $credentials['fname']         = $db->real_escape_string($_GET['txtFirstName']);
      $credentials['lname']         = $db->real_escape_string($_GET['txtLastName']);
      $credentials['birthDate']     = $db->real_escape_string($_GET['txtBirthDate']);
      $credentials['contactNumber'] = $db->real_escape_string($_GET['txtContactNumber']);
      if (isset($_FILES['file'])) {
        $credentials['image'] = $_FILES['file'];
      }
      echo $account->editProfile($credentials);
      break;
    }
  }
}
?>