<?php
  session_start();
	require_once '../files/db.php';
  if (isset($_POST['email'])){
    try{
      $fname = stripslashes($_POST['fname']); // removes backslashes
      $fname = mysqli_real_escape_string($db,$fname); //escapes special characters in a string
      $lname = stripslashes($_POST['lname']); // removes backslashes
      $lname = mysqli_real_escape_string($db,$lname); //escapes special characters in a string
      $email = stripslashes($_POST['email']);
      $email = mysqli_real_escape_string($db,$email);
      $password = stripslashes($_POST['password']);
      $password = mysqli_real_escape_string($db,$password);
      $password = password_hash($password, PASSWORD_DEFAULT);
      $query = "INSERT INTO `account` VALUES ('$email', '$password','User', '$fname', '$lname')";
      $result = mysqli_query($db,$query);
      if($result){
        echo "ok";
      }
      else
      {
        echo "Already registered! Please try a different one.";
      }
    }
    catch(PDOException $e){
			echo $e->getMessage();
		}
  }
?>