<?php
	$root = isset($root) ? $root : '';
	require_once $root.'../files/strings.php';
	
	$servername = "localhost";
	$username = "root";
	$password = PASSWORD;
	$database = "nwh";
	// Create connection
	$db = mysqli_connect($servername, $username, $password, $database);

	// Check connection
	if (!$db)
	{
		$db = mysqli_connect("ns-database.cqlx1o0ayzo0.us-east-1.rds.amazonaws.com", "NeonSpectrum", $password, $database);
		if(!db)
			die("Connection failed: " . $db->connect_error);
	}
?>