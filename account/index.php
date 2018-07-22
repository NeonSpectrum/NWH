<?php
@session_start();
require_once '../files/autoload.php';
if (isset($_POST['mode']) && $system->validateToken()) {
  $credentials = [];
  switch ($_POST['mode']) {
  case 'login':{
      if ($account->login(['email' => $_POST['txtEmail'], 'password' => $_POST['txtPassword'], 'remember' => isset($_POST['cbxRemember']) ? $_POST['cbxRemember'] : 'off'])) {
        echo true;
      } else {
        echo INVALID_EMAIL_PASSWORD;
      }
      break;
    }
  case 'register':{
      $credentials['txtFirstName']     = $_POST['txtFirstName'];
      $credentials['txtLastName']      = $_POST['txtLastName'];
      $credentials['txtEmail']         = $_POST['txtEmail'];
      $credentials['txtPassword']      = $_POST['txtPassword'];
      $credentials['txtContactNumber'] = $_POST['txtContactNumber'];
      $credentials['txtBirthDate']     = $_POST['txtBirthDate'];
      $credentials['txtNationality']   = $_POST['txtNationality'];
      if ($_POST['verify'] == 'false') {
        echo $account->register($credentials, false);
      } else {
        $captcha = $system->verifyCaptcha($_POST['g-recaptcha-response']);
        if ($captcha === true) {
          echo $account->verifyRegistration($credentials, true);
        } else {
          echo $captcha;
        }
      }
      break;
    }
  case 'changePassword':{
      $forgot                 = isset($_POST['txtEmail']) ? true : false;
      $email                  = $_POST['txtEmail'] ?? $system->decrypt($_SESSION['account']);
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
  case 'forgotPassword':{
      $email = $system->filter_input($_POST['txtEmail']);
      if ($account->forgotPassword($email)) {
        echo true;
      } else {
        echo INVALID_EMAIL;
      }
      break;
    }
  case 'editAccount':{
      parse_str($_POST['data'], $data);
      $credentials['email']         = $system->filter_input($system->decrypt($_SESSION['account']));
      $credentials['fname']         = $system->filter_input($data['txtFirstName']);
      $credentials['lname']         = $system->filter_input($data['txtLastName']);
      $credentials['birthDate']     = $system->filter_input($data['txtBirthDate']);
      $credentials['contactNumber'] = $system->filter_input($data['txtContactNumber']);
      $credentials['nationality']   = $system->filter_input($data['txtNationality']);
      if (isset($_FILES['file'])) {
        $credentials['image'] = $_FILES['file'];
      }
      echo $account->editProfile($credentials);
      break;
    }
  }
} else if (isset($_GET['mode'])) {
  switch ($_GET['mode']) {
  case 'register':{
      parse_str($system->decrypt(str_replace(' ', '+', $_GET['token'])), $credentials);
      if (isset($credentials['txtEmail'])) {
        echo $account->register($credentials);
        echo print_r($credentials);
      }
      break;
    }
  case 'logout':{
      $account->logout();
      break;
    }
  case 'checkEmail':{
      if ($account->checkEmail($_GET['txtEmail'])) {
        http_response_code(406);
      } else {
        http_response_code(200);
      }
      break;
    }
  }
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>
