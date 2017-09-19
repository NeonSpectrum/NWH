<?php
  session_start();
  if(!isset($root))
    $root='';
	require_once $root.'../files/db.php';
  if (isset($_POST)){
    try{
      $email = stripslashes($_POST['txtEmail']); // removes backslashes
      $email = mysqli_real_escape_string($db,$email); //escapes special characters in a string
      $password = stripslashes($_POST['txtOldPass']);
      $password = mysqli_real_escape_string($db,$password);
      $newpass = stripslashes($_POST['txtNewPass']);
      $newpass = mysqli_real_escape_string($db,$newpass);
      $newpass = password_hash($newpass, PASSWORD_DEFAULT);
      $query = "SELECT * FROM `account` WHERE EmailAddress='$email'";
      $result = mysqli_query($db,$query) or die(mysql_error());
      $row = $result->fetch_assoc();
      $count = mysqli_num_rows($result);
      if($count==1 && password_verify($password, $row['Password']) && strpos($email,'@') && strpos($email,'.'))
      {
        $query = "UPDATE account SET Password='$newpass' WHERE EmailAddress='$email'";
        $result = mysqli_query($db,$query) or die(mysql_error());
        if(mysqli_affected_rows($db)!=0)
        {
          echo "ok";
        }
      }
      elseif(!strpos($email, '@') || !strpos($email, '.'))
      {
        echo "Invalid Email Address!";
      }
      elseif($count==0)
      {
        echo "Invalid Account Details";
      }
      elseif(!password_verify($password, $row['Password']))
      {
        echo "Invalid Old Password!";
      }
      else
      {
        echo "Incorrect Details!";
      }
    }
    catch(PDOException $e){
			echo $e->getMessage();
		}
  }
?>