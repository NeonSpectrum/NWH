<?php
  session_start();
	require_once '../files/db.php';
  if (isset($_POST['email'])){
    try{
      $email = stripslashes($_POST['email']); // removes backslashes
      $email = mysqli_real_escape_string($db,$email); //escapes special characters in a string
      $password = stripslashes($_POST['password']);
      $password = mysqli_real_escape_string($db,$password);
      $query = "SELECT * FROM `account` WHERE EmailAddress='$email'";
      $result = mysqli_query($db,$query) or die(mysql_error());
      $row = $result->fetch_assoc();
      $count = mysqli_num_rows($result);
      if($count==1 && password_verify($password, $row['Password'])){
        echo "ok";
        $_SESSION['logged'] = true;
        $_SESSION['fname'] = $row['FirstName'];
        $_SESSION['lname'] = $row['LastName'];
      }
      else{
        echo "Invalid Username or Password.";
      }
    }
    catch(PDOException $e){
			echo $e->getMessage();
		}
  }
?>