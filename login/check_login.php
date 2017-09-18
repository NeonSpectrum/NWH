<?php
  session_start();
  if(!isset($root))
    $root='';
	require_once $root.'../files/db.php';
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
      if($count==1 && password_verify($password, $row['Password']) && $row['isLogged']==0){
        $_SESSION['logged'] = true;
        $_SESSION['email'] = $row['EmailAddress'];
        $_SESSION['fname'] = $row['FirstName'];
        $_SESSION['lname'] = $row['LastName'];
        $_SESSION['picture'] = $row['ProfilePicture'];
        $_SESSION['accounttype'] = $row['AccountType'];
        //update isLogged
        $query = "UPDATE account SET isLogged=0 WHERE EmailAddress='$email'";
        $result = mysqli_query($db,$query) or die(mysql_error());
        $cookie = "email=".$email."&password=".$row['Password'];
        if(!empty($_POST["remembercheckbox"])) {
          setcookie ("nwhAuth",$cookie,time()+ (60 * 60 * 24 * 7), "/");
        } else {
          if(isset($_COOKIE["nwh_email"])) {
            setcookie ("nwh_email","");
          }
          if(isset($_COOKIE["nwh_password"])) {
            setcookie ("nwh_password","");
          }
        }
        echo "ok";
      }
      elseif($row['isLogged']==1)
      {
        echo "Already Logged In.";
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