<?php
  session_start();
	require_once $root.'../files/db.php';
  $email = $_SESSION['email'];
  //update isLogged
  $query = "UPDATE account SET isLogged=0 WHERE EmailAddress='$email'";
  $result = mysqli_query($db,$query) or die(mysql_error());
	if(session_destroy()) // Destroying All Sessions
	{
    if(isset($link))
    {
      header("location:'$link'");
    }
		header("location:".$_SERVER['HTTP_REFERER']); // Redirecting To Home Page
	}
?>