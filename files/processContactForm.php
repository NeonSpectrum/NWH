<?php
  require '../files/functions.php';
  
  $name = $_POST['txtName'];
  $email = $_POST['txtEmail'];
  $message = $_POST['txtMessage'];

  $body = "Name: $name<br/>Email: $email<br/>Message: $message";
  $subject = "Message from $email";
  echo sendMail(EMAIL,$subject,$body);
?>