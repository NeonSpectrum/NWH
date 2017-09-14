<?php
  // LOGIN
  if (isset($_POST['email'])){
    $email = stripslashes($_REQUEST['email']); // removes backslashes
    $email = mysqli_real_escape_string($db,$email); //escapes special characters in a string
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($db,$password);
    
    $query = "SELECT * FROM `account` WHERE emailaddress='$email' and password=SHA('$password')";
    $result = mysqli_query($db,$query) or die(mysql_error());
    $row = $result->fetch_assoc();
    $count = mysqli_num_rows($result);
    if($count==1){
      echo "<script>alert('Login Successfully!');</script>";
      $_SESSION['logged'] = true;
      $_SESSION['fname'] = $row['FirstName'];
      $_SESSION['lname'] = $row['LastName'];
    }
    else{
      echo "<script>alert('Either username or password is incorrect!');</script>";
    }
  }

	// REGISTER
	if (isset($_REQUEST['emailreg'])){
		$fname = stripslashes($_REQUEST['fname']); // removes backslashes
		$fname = mysqli_real_escape_string($db,$fname); //escapes special characters in a string
		$lname = stripslashes($_REQUEST['lname']); // removes backslashes
		$lname = mysqli_real_escape_string($db,$lname); //escapes special characters in a string
		$email = stripslashes($_REQUEST['emailreg']);
		$email = mysqli_real_escape_string($db,$email);
		$password = stripslashes($_REQUEST['password']);
		$password = mysqli_real_escape_string($db,$password);

		$query = "INSERT into `account` VALUES ('$email', SHA('$password'), '$fname', '$lname')";
		$result = mysqli_query($db,$query);
		if($result){
			echo "<script>alert('You have registered successfully!')</script>";
    }
    else
    {
      echo "<script>alert('Already registered! Please try a different one.');</script>";
    }
  }
?>