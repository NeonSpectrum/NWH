<?php
	$root = isset($root) ? $root : '';
	require_once $root.'../files/strings.php';
	
	$servername = "neonspectrumdb.redirectme.net";
	$username = "NeonSpectrum";
	$password = PASSWORD;
	$database = "nwh";

	$db = mysqli_connect($servername, $username, $password, $database);

	if (!$db)
	{
		$db = mysqli_connect("localhost", "root", $password, $database);
		if(!db)
			die("Connection failed: " . $db->connect_error);
	}
?>