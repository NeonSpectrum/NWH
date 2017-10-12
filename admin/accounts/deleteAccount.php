<?php
	session_start();
	$root='../';
	require_once $root.'/../files/db.php';
	if (isset($_POST))
	{
		try
		{
			$arr = array();
			$email = stripslashes($_POST['cmbEmail']); // removes backslashes
			$email = mysqli_real_escape_string($db, $email); //escapes special characters in a string
			$query = "SELECT * FROM account WHERE EmailAddress='$email'";
			$result = mysqli_query($db,$query);
			$row = $result->fetch_assoc();
			if($_SESSION['accountType'] != 'Owner')
			{
				echo PRIVILEGE_DELETE_ACCOUNT;
				return;
			}
		
			$query = "DELETE FROM `account` WHERE EmailAddress='$email'";
			$result = mysqli_query($db, $query) or die(mysql_error());
			if (mysqli_affected_rows($db)!=0)
			{
				echo "ok";
			}
			else
			{
				echo UNABLE_DELETE_EMAIL_ACCOUNT;
			}
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
		}
	}
?>