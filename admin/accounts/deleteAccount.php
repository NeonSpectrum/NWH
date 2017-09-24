<?php
  session_start();
	require_once '../../files/db.php';
	if (isset($_POST))
	{
		try
		{
			$arr = array();
			$email = stripslashes($_POST['cmbEmail']); // removes backslashes
			$query="SELECT * FROM account WHERE EmailAddress='$email'";
			$result = mysqli_query($db,$query);
			$row = $result->fetch_assoc();
			if($_SESSION['accountType'] != 'Owner' && $row['AccountType']=='Owner')
			{
				echo "You do not have the privilege to delete this account.";
				return;
			}
			$email = mysqli_real_escape_string($db, $email); //escapes special characters in a string
		
			$query = "DELETE FROM `account` WHERE EmailAddress='$email'";
			$result = mysqli_query($db, $query) or die(mysql_error());
			if (mysqli_affected_rows($db)!=0) {
					echo "ok";
			} else {
					echo "Unable to delete ".$email."'s account";
			}
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
		}
	}
?>