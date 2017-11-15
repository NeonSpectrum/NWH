<?php
  require '../files/functions.php';
  
  $name = $_POST['txtName'];
  $email = $_POST['txtEmail'];
  $subject = $_POST['txtSubject'];
  $message = $_POST['txtMessage'];

  $body = "Name: $name<br/>Email: $email<br/>Subject: $subject<br/>Message: $message";
  $subject = "Contact from $email";
  echo sendMail(EMAIL,$subject,$body);
?>