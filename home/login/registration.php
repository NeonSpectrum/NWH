<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
		<title>Registration</title>
	</head>
	<body>
		<?php
			require('../DBConnection.php');
		    // If form submitted, insert values into the database.
		    if (isset($_REQUEST['email'])){
				$fname = stripslashes($_REQUEST['fname']); // removes backslashes
				$fname = mysqli_real_escape_string($db,$fname); //escapes special characters in a string
				$lname = stripslashes($_REQUEST['lname']); // removes backslashes
				$lname = mysqli_real_escape_string($db,$lname); //escapes special characters in a string
				$email = stripslashes($_REQUEST['email']);
				$email = mysqli_real_escape_string($db,$email);
				$password = stripslashes($_REQUEST['password']);
				$password = mysqli_real_escape_string($db,$password);

				$trn_date = date("Y-m-d H:i:s");
		        $query = "INSERT into `account` VALUES ('$email', '".md5($password)."', '$fname', '$lname')";
		        $result = mysqli_query($db,$query);
		        if($result){
		            echo "<div class='form'><h3>You are registered successfully.</h3><br/>Click <a href='../..'>here</a> to go back.</div>";
		        }
		    }else{
		?>
		<div class="form">
			<h1>Registration</h1>
			<form name="registration" action="" method="post">
				<input type="email" name="email" placeholder="Email" required /><br/><br/>
				<input type="password" name="password" placeholder="Password" required /><br/><br/>
				<input type="text" name="fname" placeholder="First Name" required /><br/><br/>
				<input type="text" name="lname" placeholder="Last Name" required /><br/><br/>
				<input type="submit" name="submit" value="Register" />
			</form>
		</div>
		<?php } ?>
	</body>
</html>
