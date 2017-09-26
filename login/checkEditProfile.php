<?php
  session_start();
  $root = isset($root) ? $root : '';
	require_once $root.'../files/db.php';
	
	$pass = $_POST['txtNewPassword'];
	$rpass = $_POST['txtRetypeNewPassword'];
	if($pass!=$rpass)
	{
		echo VERIFY_PASSWORD_ERROR;
		return;
	}
  if (isset($_POST)){
    try{
      $email = $_POST['txtEmail'];
      $fname = $_POST['txtFirstName'];
			$lname = $_POST['txtLastName'];
			$query = "SELECT * FROM `account` WHERE EmailAddress='$email'";
      $result = mysqli_query($db,$query) or die(mysql_error());
      $row = $result->fetch_assoc();
			$count = mysqli_num_rows($result);
			if($_POST['txtOldPassword']!='')
			{
				if(!password_verify($_POST['txtOldPassword'], $row['Password']))
				{
					echo OLD_PASSWORD_ERROR;
					return;
				}
			}
      if($count==1)
      {
				$password = $_POST['txtNewPassword']!='' ? password_hash($_POST['txtNewPassword'], PASSWORD_DEFAULT) : '';
        $query = "UPDATE account SET FirstName='$fname', LastName='$lname'";
				$query.= $password=='' ? $password : ", Password='$password'";
				$query.= " WHERE EmailAddress='$email'";
        $result = mysqli_query($db,$query) or die(mysql_error());
        if(mysqli_affected_rows($db)!=0 || ($_POST['profilePic']==1 && mysqli_affected_rows($db)==0))
        {
					$_SESSION['fname']=$fname;
					$_SESSION['lname']=$lname;
          echo "ok";
       	}
				else
				{
					echo NO_UPDATE;
				}
			}
			else
			{
				echo ERROR_OCCURED;
			}
    }
    catch(PDOException $e){
			echo $e->getMessage();
		}
  }
?>