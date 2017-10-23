<?php
	session_start();
	$root = isset($root) ? $root : '';
	$adminPage = isset($adminPage) ? $adminPage : false;
	$home = isset($home) ? $home : false;
	require_once $root.'../files/db.php';
	if(isset($_COOKIE['nwhAuth']))
	{
		parse_str(openssl_decrypt($_COOKIE['nwhAuth'],"AES-128-ECB",ENCRYPT_KEYWORD));
		$cookie = $_COOKIE['nwhAuth'];
		$query = "SELECT * FROM `account` WHERE EmailAddress='$email' AND Password='$password'";
		$result = mysqli_query($db,$query) or die(mysql_error());
		$row = $result->fetch_assoc();
		$count = mysqli_num_rows($result);
		if($count==1){
			$_SESSION['email'] = $row['EmailAddress'];
			$_SESSION['fname'] = $row['FirstName'];
			$_SESSION['lname'] = $row['LastName'];
			$_SESSION['picture'] = $row['ProfilePicture'];
			$_SESSION['accountType'] = $row['AccountType'];
		}
	}
	require $root.'../files/db.php';
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<title>Northwood Hotel</title>
			<?php 
				require $root.'../files/meta.php';
				if($adminPage)
				{
					require $root.'../files/cssAdmin.php';
				}
				else
				{
					require $root.'../files/cssMain.php';
				}
			;?>
	</head>
	<body style="padding-right:0px !important">
	<?php
		if(!$adminPage)
			echo "<div class='loadingIcon'></div>";
		if(!$home && !$adminPage)
			echo "<div style='height:70px'></div>";
	?>
	<a style="position:absolute;bottom:5px;left:5px;z-index:5;text-decoration:none" href="javascript:location.reload(true)">Reload</a>
	<div id="alertBox" style="display:none"></div>