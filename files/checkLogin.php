<?php
	session_start();
  require_once 'db.php';
  if (isset($_POST)) {
    try {
      $email = stripslashes($_POST['txtEmail']); // removes backslashes
      $email = mysqli_real_escape_string($db,$email); //escapes special characters in a string
      $password = stripslashes($_POST['txtPassword']);
      $password = mysqli_real_escape_string($db,$password);
      $query = "SELECT * FROM `account` WHERE EmailAddress='$email'";
      $result = mysqli_query($db,$query) or die(mysql_error());
      $row = $result->fetch_assoc();
      $count = mysqli_num_rows($result);
      if($count==1 && password_verify($password, $row['Password']) && strpos($email,'@') && strpos($email,'.')) {
        $session_id = session_id();
        $query = "UPDATE account SET SessionID='$session_id' WHERE EmailAddress='$email'";
        mysqli_query($db,$query);
        $_SESSION['email'] = $row['EmailAddress'];
        $_SESSION['fname'] = $row['FirstName'];
        $_SESSION['lname'] = $row['LastName'];
        $_SESSION['picture'] = $row['ProfilePicture'];
        $_SESSION['accountType'] = $row['AccountType'];
        // update isLogged
        $cookie = openssl_encrypt("email=".$email."&password=".$row['Password'],"AES-128-ECB",ENCRYPT_KEYWORD);
        // if(!empty($_POST["cbxRemember"]))
        // {
          setcookie ("nwhAuth",$cookie,time()+ (60 * 60 * 24 * 7), "/");
        // }
        // else
        // {
        // 	if(isset($_COOKIE["nwhAuth"]))
        // 	{
        // 		setcookie ('nwhAuth', '', time() - (60 * 60 * 24 * 7),'/');
        // 		unset($_COOKIE['nwhAuth']);
        // 	}
        // }
        echo "ok";
      } elseif(!strpos($email, '@') || !strpos($email, '.')) {
        echo FORMAT_ERROR_EMAIL;
      } else {
        echo INVALID_EMAIL_PASSWORD;
      }
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }
?>