<?php
require_once '../files/db.php';

$name    = $_POST['txtName'];
$email   = $_POST['txtEmail'];
$message = $_POST['txtMessage'];

$subject = "Message from $email";
$body    = "Name: $name<br/>Email: $email<br/>Message: $message";
echo sendMail("Northwood Hotel Support", SUPPORT_EMAIL, $subject, $body);
?>