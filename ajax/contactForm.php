<?php
require_once '../files/autoload.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $name          = $_POST['txtName'];
  $email         = $_POST['txtEmail'];
  $contactNumber = $_POST['txtContactNumber'];
  $message       = $_POST['txtMessage'];

  echo $system->sendContactForm($name, $email, $contactNumber, $message);
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>