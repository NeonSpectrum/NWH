<?php
  require_once __DIR__.'/../assets/PHPMailer/src/Exception.php';
  require_once __DIR__.'/../assets/PHPMailer/src/PHPMailer.php';
  require_once __DIR__.'/../assets/PHPMailer/src/SMTP.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  function sendMail($head, $email, $subject, $body) {
    try {
      $mail = new PHPMailer(true); 
      $mail->isSMTP();
      $mail->Host = "ssl://cpanel02wh.sin1.cloud.z.com";
      $mail->SMTPAuth = true;
      $mail->Username = NOREPLY_EMAIL;
      $mail->Password = PASSWORD;
      $mail->SMTPSecure = 'tls';
      $mail->Port = 465;          
  
      $mail->setFrom(NOREPLY_EMAIL, $head);
      $mail->addAddress($email);
  
      $mail->isHTML(true);
      $mail->Subject = "$subject";
      $mail->Body = "$body";
  
      $mail->send();
      return true;
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