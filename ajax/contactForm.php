<?php
require_once '../files/autoload.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $name    = $_POST['txtName'];
  $email   = $_POST['txtEmail'];
  $message = $_POST['txtMessage'];

  echo $system->sendContactForm($name, $email, $message);
}
?>