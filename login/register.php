<?php
	session_start();
  $root = isset($root) ? $root : '';
	require_once $root.'../files/db.php';
	if(isset($_SERVER['QUERY_STRING']))
  {
    parse_str(openssl_decrypt($_SERVER['QUERY_STRING'],"AES-128-ECB","northwoodhotel"));
		$fname = $txtFirstName;
		$lname = $txtLastName;
		$email = $txtEmail;
		$password = $txtPassword;
		$query = "INSERT INTO `account` VALUES ('$email', '$password', 'User', 'default.png', '$fname', '$lname',0)";
		$result = mysqli_query($db,$query);
		if(mysqli_affected_rows($db)!=0)
		{
			echo '<script>alert("Registered Successfully!");location.href = "/nwh/";</script>';
      exit();
		}
		else
		{
      echo 'Error Occured!';
    }
  }
?>