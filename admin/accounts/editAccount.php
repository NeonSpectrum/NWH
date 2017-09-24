<?php
  session_start();
	require_once '../../files/db.php';
	if (isset($_POST))
	{
		try
		{
      $email = $_POST['cmbEmail'];
			$accounttype = $_POST['cmbAccountType'];
			$query="SELECT * FROM account WHERE EmailAddress='$email'";
			$result = mysqli_query($db,$query);
			$row = $result->fetch_assoc();
			if($_SESSION['accountType'] != 'Owner' && $row['AccountType']=='Owner')
			{
				echo "You do not have the privilege to modify this account.";
				return;
			}
      $profilepicture = $_POST['txtProfilePicture'];
      $firstname = $_POST['txtFirstName'];
      $lastname = $_POST['txtLastName'];
      $islogged = $_POST['txtIsLogged'];
      $query = "UPDATE `account` SET AccountType='".$accounttype."',ProfilePicture='".$profilepicture."',Firstname='".$firstname."',Lastname='".$lastname."',isLogged=".$islogged." WHERE EmailAddress='".$email."'";
      $result = mysqli_query($db,$query);
      if(mysqli_affected_rows($db)!=0){
        echo "ok";
      }
      else{
        echo "Something went wrong!";
      }
    }
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
  }
?>