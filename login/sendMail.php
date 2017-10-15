<?php
	// Pear Mail Library
	$root = isset($root) ? $root : '';
	$domain = "neonspectrum.myftp.org";
	require_once "Mail.php";
	require_once $root."../files/db.php";

	//register
	if(isset($_POST['txtFirstName']))
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
			$from = '<'.EMAIL.'>';
			$to = "<$email>";
			$subject = 'Verify Email Confirmation';
			$body = "Please proceed to this link to register your account:\nhttp://$domain/nwh/login/register.php?$data";

			$headers = array(
				'From' => $from,
				'To' => $to,
				'Subject' => $subject
			);

			$smtp = Mail::factory('smtp', array(
				'host' => 'ssl://smtp.gmail.com',
				'port' => '465',
				'auth' => true,
				'username' => EMAIL,
				'password' => PASSWORD
			));

			$mail = $smtp->send($to, $headers, $body);

			if (PEAR::isError($mail)) {
					echo('<p>' . $mail->getMessage() . '</p>');
			} else {
					echo('ok');
			}
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

	//forgot
	else
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
			$from = '<'.EMAIL.'>';
			$to = "<$email>";
			$subject = 'Forgot Password Confirmation';
			$body = "Please proceed to this link to reset your password:\nhttp://$domain/nwh/login/resetPassword.php?$data\n\nYour new password will be: $randomNumber";

			$headers = array(
				'From' => $from,
				'To' => $to,
				'Subject' => $subject
			);

			$smtp = Mail::factory('smtp', array(
				'host' => 'ssl://smtp.gmail.com',
				'port' => '465',
				'auth' => true,
				'username' => EMAIL,
				'password' => PASSWORD
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
			echo FORMAT_ERROR_EMAIL;
		}
		else{
			echo INVALID_EMAIL;
		}
	}
?>