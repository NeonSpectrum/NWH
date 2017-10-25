<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	require_once $root.'../files/strings.php';

	require $root.'../packages/PHPMailer/src/Exception.php';
	require $root.'../packages/PHPMailer/src/PHPMailer.php';
	require $root.'../packages/PHPMailer/src/SMTP.php';

	function sendMail($email,$subject,$body)
	{
		try
		{
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
		}
		catch(Exception $e)
		{
			return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
		}
	}
?>