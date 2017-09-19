<?php
  session_start();
  if(!isset($root))
    $root='';
	require_once $root.'../files/db.php';
  if (isset($_POST)){
    try{
      $email = stripslashes($_POST['txtEmail']); // removes backslashes
      $email = mysqli_real_escape_string($db,$email);
      $password = password_hash('1234', PASSWORD_DEFAULT);
      $query = "UPDATE account SET Password='$password' WHERE EmailAddress='$email'";
      $result = mysqli_query($db,$query) or die(mysql_error());
      if(mysqli_affected_rows($db)!=0){
        echo "ok";
      }
      else{
        echo "Invalid Email Address!";
      }
    }
    catch(PDOException $e){
			echo $e->getMessage();
		}
  }
?>