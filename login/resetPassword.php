<?php
	// Pear Mail Library
  $root = isset($root) ? $root : '';
  require_once $root."../files/db.php";
  if(isset($_SERVER['QUERY_STRING']))
  {
    parse_str(openssl_decrypt($_SERVER['QUERY_STRING'],"AES-128-ECB","northwoodhotel"));
    $newPass = password_hash($newPass, PASSWORD_DEFAULT);
    $query = "UPDATE account SET Password='$newPass' WHERE EmailAddress='$email'";
    $result = mysqli_query($db,$query) or die(mysql_error());
    if(mysqli_affected_rows($db)!=0)
    {
      echo '<script>alert("Reset Successfully!");location.href = "/nwh/";</script>';
      exit();
    }
		else
		{
      echo ERROR_OCCURED;
    }
  }
?>