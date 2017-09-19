<?php
  // Pear Mail Library
  require_once "Mail.php";
  require_once "../files/db.php";
  if(isset($_POST))
  {
    $email = stripslashes($_POST['txtEmail']); // removes backslashes
    $email = mysqli_real_escape_string($db,$email); //escapes special characters in a string
    $query = "SELECT * FROM `account` WHERE EmailAddress='$email'";
    $result = mysqli_query($db,$query) or die(mysql_error());
    $row = $result->fetch_assoc();
    $count = mysqli_num_rows($result);
    if($count==1 && strpos($email,'@') && strpos($email,'.'))
    {
      $randomNumber = mt_rand( 10000000, 99999999);
      $data = openssl_encrypt("email=".$email."&newPass=".$randomNumber,"AES-128-ECB","northwoodhotel");
      $from = '<neonspectrumph@gmail.com>';
      $to = '<'.$email.'>';
      $subject = 'Verify Email Confirmation';
      $body = "Please proceed to this link to reset your password:\nhttp://neonspectrum.ddns.net/nwh/login/resetPassword.php?".$data."\n\nYour new password will be: <b>".$randomNumber."</b>;

      $headers = array(
          'From' => $from,
          'To' => $to,
          'Subject' => $subject
      );

      $smtp = Mail::factory('smtp', array(
              'host' => 'ssl://smtp.gmail.com',
              'port' => '465',
              'auth' => true,
              'username' => 'neonspectrumph@gmail.com',
              'password' => 'yuanhua12'
          ));

      $mail = $smtp->send($to, $headers, $body);

      if (PEAR::isError($mail)) {
          echo('<p>' . $mail->getMessage() . '</p>');
      } else {
          echo('ok');
      }
    }
    elseif(!strpos($email, '@') || !strpos($email, '.'))
    {
      echo "Invalid Format!";
    }
    else{
      echo 'Invalid Email Address';
    }
  }
?>