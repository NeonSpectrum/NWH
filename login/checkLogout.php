<?php
	session_start();
	$root = isset($root) ? $root : '';
	require_once $root.'../files/db.php';
	$email = $_SESSION['email'];
	if(isSet($_COOKIE['nwhAuth']))
	{
		setcookie ('nwhAuth', '', time() - (60 * 60 * 24 * 7),'/');
		unset($_COOKIE['nwhAuth']);
	}
	if(session_destroy())
	{
		header("location:".$_SERVER['HTTP_REFERER']);
	}
?>