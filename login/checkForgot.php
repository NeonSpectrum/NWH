<?php
	// Pear Mail Library
	$root = isset($root) ? $root : '';
	$domain = $_SERVER['SERVER_NAME'];

	require_once $root.'../login/mailer.php';
	require_once $root."../files/db.php";

	parse_str(openssl_decrypt($_SERVER['QUERY_STRING'],"AES-128-ECB",ENCRYPT_KEYWORD));

	if(isset($newPass))
	{
		parse_str(openssl_decrypt($_SERVER['QUERY_STRING'],"AES-128-ECB",ENCRYPT_KEYWORD));
		$newPass = password_hash($newPass, PASSWORD_DEFAULT);
		$query = "UPDATE account SET Password='$newPass' WHERE EmailAddress='$email'";
		$result = mysqli_query($db,$query) or die(mysql_error());
		if(mysqli_affected_rows($db)!=0)
		{
			echo '<script>alert("Reset Successfully!");location.href="/nwh/";</script>';
			exit();
		}
		else
		{
			echo ERROR_OCCURED;
		}
	}
	else if(isset($_POST))
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
			$subject = "Northwood Hotel Forgot Password";
			$body = "Please proceed to this link to reset your password:<br/>http://$domain/nwh/login/checkForgot.php?$data<br/><br/>Your new password will be: <b>$randomNumber</b>";
			
			echo sendMail("$email","$subject","$body");
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