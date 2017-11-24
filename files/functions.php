<?php
  
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  require_once 'db.php';

  require '../assets/PHPMailer/src/Exception.php';
  require '../assets/PHPMailer/src/PHPMailer.php';
  require '../assets/PHPMailer/src/SMTP.php';

  function sendMail($email, $subject, $body) {
    $email = (string)$email;
    $subject = (string)$subject;
    $body = (string)$body;
    try {
      $mail = new PHPMailer(true); 
      $mail->isSMTP();
      $mail->Host = "ssl://smtp.gmail.com";
      $mail->SMTPAuth = true;
      $mail->Username = EMAIL;
      $mail->Password = PASSWORD;
      $mail->SMTPSecure = 'tls';
      $mail->Port = 465;          
  
      $mail->setFrom(EMAIL, "Northwood Hotel");
      $mail->addAddress($email);
  
      $mail->isHTML(true);
      $mail->Subject = "$subject";
      $mail->Body = "$body";
  
      $mail->send();
      return "ok";
    } catch(Exception $e) {
      return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
  }

  function nwh_encrypt($string) {
    return openssl_encrypt($string, "AES-128-ECB", ENCRYPT_KEYWORD);
  }
  
  function nwh_decrypt($string) {
    return openssl_decrypt($string, "AES-128-ECB", ENCRYPT_KEYWORD);
  }
?>