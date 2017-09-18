<?php
  session_start();
	require_once '../../files/db.php';
  if (isset($_POST['email'])){
    try{
      $arr = array();
      $email = stripslashes($_POST['email']); // removes backslashes
      $email = mysqli_real_escape_string($db,$email); //escapes special characters in a string
     
      $query = "DELETE FROM `account` WHERE EmailAddress='$email'";
      $result = mysqli_query($db,$query) or die(mysql_error());
      if($result){
        echo "ok";
      }
      else
      {
        echo "Unable to delete ".$email."'s account";
      }
    }
    catch(PDOException $e){
			echo $e->getMessage();
		}
  }
?>