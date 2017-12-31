<?php
require_once '../files/autoload.php';
if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $name          = $_POST['txtName'];
  $email         = $_POST['txtEmail'];
  $contactNumber = $_POST['txtContactNumber'];
  $message       = $_POST['txtMessage'];

  echo $system->sendContactForm($name, $email, $contactNumber, $message);
}
?>