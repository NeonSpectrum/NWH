<?php
	session_start();
	$root = isset($root) ? $root : '';
	require_once $root.'../files/db.php';
	if(isset($_SERVER['QUERY_STRING']))
	{
		parse_str(openssl_decrypt($_SERVER['QUERY_STRING'],"AES-128-ECB",ENCRYPT_KEYWORD));
		$fname = $txtFirstName;
		$lname = $txtLastName;
		$email = $txtEmail;
		$password = $txtPassword;
		$query = "INSERT INTO `account` VALUES ('$email', '$password', 'User', 'default.png', '$fname', '$lname')";
		$result = mysqli_query($db,$query);
		if(!$result)
		{
			echo '<script>alert("Already Registered!");location.href="/nwh/";</script>';
		}
		else if(mysqli_affected_rows($db)!=0)
		{
			echo '<script>alert("Registered Successfully!");location.href="/nwh/";</script>';
		}
	}
?>