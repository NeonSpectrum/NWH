<?php
@session_start();
require_once '../files/autoload.php';

if (isset($_POST['mode']) && $system->validateToken($_POST['csrf_token'])) {
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
      break;
    }
  case "changePassword":{
      $forgot                 = isset($_POST['txtEmail']) ? true : false;
      $email                  = isset($_SESSION['account']['email']) ? $_SESSION['account']['email'] : $_POST['txtEmail'];
      $credentials['email']   = $system->filter_input($email);
      $credentials['oldpass'] = $forgot ? null : $system->filter_input($_POST['txtOldPass'], true);
      $credentials['newpass'] = password_hash($system->filter_input($_POST['txtNewPass'], true), PASSWORD_DEFAULT);
      $credentials['token']   = isset($_POST['txtToken']) ? $system->filter_input($_POST['txtToken']) : null;

      if ($account->changePassword($credentials, $forgot) == true) {
        echo true;
      } else {
        echo OLD_PASSWORD_ERROR;
      }
      break;
    }
  case "forgotPassword":{
      $email = $system->filter_input($_POST['txtEmail']);
      if ($account->forgotPassword($email)) {
        echo true;
      } else {
        echo INVALID_EMAIL;
      }
      break;
    }
  case "editAccount":{
      parse_str($_POST['data'], $data);
      $credentials['email']         = $system->filter_input($_SESSION['account']['email']);
      $credentials['fname']         = $system->filter_input($data['txtFirstName']);
      $credentials['lname']         = $system->filter_input($data['txtLastName']);
      $credentials['birthDate']     = $system->filter_input($data['txtBirthDate']);
      $credentials['contactNumber'] = $system->filter_input($data['txtContactNumber']);
      if (isset($_FILES['file'])) {
        $credentials['image'] = $_FILES['file'];
      }
      echo $account->editProfile($credentials);
      break;
    }
  case "deleteAccount":{
      $email = $system->filter_input($_POST['txtEmail']);
      echo $account->deleteAccount($email);
      break;
    }
  }
} else if (isset($_GET['mode'])) {
  switch ($_GET['mode']) {
  case "register":{
      // echo $system->decrypt(str_replace(" ", "+", $_GET['token']));
      // return;
      parse_str($system->decrypt(str_replace(" ", "+", $_GET['token'])), $credentials);
      if (isset($credentials['txtEmail'])) {
        echo $account->register($credentials);
        echo print_r($credentials);
      }
      break;
    }
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
  }
}
?>