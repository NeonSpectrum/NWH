<?php
  session_start();
  $root = isset($root) ? $root : '';
	require_once $root.'../files/db.php';

  if (isset($_POST)){
    try{
      $email = $_SESSION['email'];
      $fname = $_POST['txtFirstName'];
			$lname = $_POST['txtLastName'];
			$query = "UPDATE account SET FirstName='$fname', LastName='$lname' WHERE EmailAddress='$email'";
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
    catch(PDOException $e){
			echo $e->getMessage();
		}
  }
?>