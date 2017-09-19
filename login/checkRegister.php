<?php
  session_start();
  if(!isset($root))
    $root='';
	require_once $root.'../files/db.php';
  if (isset($_POST)){
    try{
      $fname = stripslashes($_POST['txtFirstName']); // removes backslashes
      $fname = mysqli_real_escape_string($db,$fname); //escapes special characters in a string
      $fname = ucwords($fname); //capitalize first character
      $lname = stripslashes($_POST['txtLastName']); // removes backslashes
      $lname = mysqli_real_escape_string($db,$lname); //escapes special characters in a string
      $lname = ucwords($lname); //capitalize first character
      $email = stripslashes($_POST['txtEmail']);
      $email = mysqli_real_escape_string($db,$email);
      $password = stripslashes($_POST['txtPassword']);
      $password = mysqli_real_escape_string($db,$password);
      $password = password_hash($password, PASSWORD_DEFAULT);
      $query = "INSERT INTO `account` VALUES ('$email', '$password', 'User', 'default.png', '$fname', '$lname',0)";
      $result = mysqli_query($db,$query);
      if($result && strpos($email,'@') && strpos($email,'.')){
        echo "ok";
      }
      elseif(strpos($email, '@') || strpos($email, '.'))
      {
        echo "Invalid Email Address!";
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