<?php
	// Pear Mail Library
	$root = isset($root) ? $root : '';
	$domain = $_SERVER['SERVER_NAME'];

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	require $root.'../PHPMailer/src/Exception.php';
	require $root.'../PHPMailer/src/PHPMailer.php';
	require $root.'../PHPMailer/src/SMTP.php';
	require_once $root."../files/db.php";

	$mail = new PHPMailer(true); 

	//register
	if(isset($_POST['txtFirstName']))
	{
		try
		{
			$fname = stripslashes($_POST['txtFirstName']); // removes backslashes
			$fname = mysqli_real_escape_string($db,$fname); //escapes special characters in a string
			$fname = ucwords($fname); //capitalize first character
			$lname = stripslashes($_POST['txtLastName']); // removes backslashes
			$lname = mysqli_real_escape_string($db,$lname); //escapes special characters in a string
			$lname = ucwords($lname); //capitalize first character
			$email = stripslashes($_POST['txtEmail']);
			$email = mysqli_real_escape_string($db,$email);
			$password = stripslashes($_POST['txtPassword']);
			$password = mysqli_real_escape_string($db,$password);
			$password = password_hash($password, PASSWORD_DEFAULT);
			$query = "SELECT * FROM account WHERE EmailAddress='$email'";
			$result = mysqli_query($db,$query);
			$count = mysqli_num_rows($result);
			if($count == 0 && strpos($email,'@') && strpos($email,'.'))
			{
				$data = "txtFirstName=$fname&txtLastName=$lname&txtEmail=$email&txtPassword=$password";
				$data = openssl_encrypt($data,"AES-128-ECB",ENCRYPT_KEYWORD);
				$mail->isSMTP();
				$mail->Host = 'ssl://smtp.gmail.com';
				$mail->SMTPAuth = true;
				$mail->Username = EMAIL;
				$mail->Password = PASSWORD;
				$mail->SMTPSecure = 'tls';
				$mail->Port = 465;          
		
				//Recipients
				$mail->setFrom(EMAIL, 'Northwood Hotel');
				$mail->addAddress($email);
		
				//Content
				$mail->isHTML(true);
				$mail->Subject = 'Northwood Hotel Account Creation';
				$mail->Body    = "Please proceed to this link to register your account:<br/>http://$domain/nwh/login/register.php?$data";
		
				$mail->send();
				echo 'ok';
			}
			elseif($count != 0)
			{
				echo ALREADY_REGISTERED;
			}
			else
			{
				echo FORMAT_ERROR_EMAIL;
			}
		}
		catch (Exception $e)
		{
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
	}

	//forgot
	else
	{
		try
		{
			$email = stripslashes($_POST['txtEmail']); // removes backslashes
			$email = mysqli_real_escape_string($db,$email); //escapes special characters in a string
			$query = "SELECT * FROM `account` WHERE EmailAddress='$email'";
			$result = mysqli_query($db,$query) or die(mysql_error());
			$row = $result->fetch_assoc();
			$count = mysqli_num_rows($result);
			if($count==1 && strpos($email,'@') && strpos($email,'.'))
			{
				$randomNumber = mt_rand(10000000, 99999999);
				$data = openssl_encrypt("email=$email&newPass=$randomNumber","AES-128-ECB",ENCRYPT_KEYWORD);
				$mail->isSMTP();
				$mail->Host = 'ssl://smtp.gmail.com';
				$mail->SMTPAuth = true;
				$mail->Username = EMAIL;
				$mail->Password = PASSWORD;
				$mail->SMTPSecure = 'tls';
				$mail->Port = 465;          
		
				//Recipients
				$mail->setFrom(EMAIL, 'Northwood Hotel');
				$mail->addAddress($email);
		
				//Content
				$mail->isHTML(true);
				$mail->Subject = 'Northwood Hotel Forgot Password';
				$mail->Body    = "Please proceed to this link to reset your password:<br/>http://$domain/nwh/login/resetPassword.php?$data<br/><br/>Your new password will be: <b>$randomNumber</b>";
		
				$mail->send();
				echo 'ok';
			}
			elseif(!strpos($email, '@') || !strpos($email, '.'))
			{
				echo FORMAT_ERROR_EMAIL;
			}
			else{
				echo INVALID_EMAIL;
			}
		}
		catch (Exception $e)
		{
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
	}
?>