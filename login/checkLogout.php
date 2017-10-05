<?php
	session_start();
	$root = isset($root) ? $root : '';
	require_once $root.'../files/db.php';
	$email = $_SESSION['email'];
	//update isLogged
	$query = "UPDATE account SET isLogged=0 WHERE EmailAddress='$email'";
	$result = mysqli_query($db,$query) or die(mysql_error());
	if(isSet($_COOKIE['nwhAuth']))
	{
		setcookie ('nwhAuth', '', time() - (60 * 60 * 24 * 7),'/');
		unset($_COOKIE['nwhAuth']);
	}
	if(session_destroy()) // Destroying All Sessions
	{
		header("location:".$_SERVER['HTTP_REFERER']); // Redirecting To Home Page
	}
?>