<?php
  session_start(); //this is the login session
	require_once 'files/db.php'; //link to database php
	if ($_SERVER['REQUEST_URI'] == '/') {
		$currentDirectory = 'home';
	} else {
		$currentDirectory = substr($_SERVER['REQUEST_URI'], 0, -1);
		$currentDirectory = substr($currentDirectory, strrpos($currentDirectory, "/") + 1);
	}
  // if (isset($_COOKIE['nwhAuth'])) {
  //   parse_str(openssl_decrypt($_COOKIE['nwhAuth'], "AES-128-ECB", ENCRYPT_KEYWORD));
  //   $cookie = $_COOKIE['nwhAuth'];
  //   $query = "SELECT * FROM `account` WHERE EmailAddress='$email' AND Password='$password'";
  //   $result = mysqli_query($db,$query) or die(mysql_error());
  //   $row = $result->fetch_assoc();
  //   $count = mysqli_num_rows($result);
  //   if($count==1){
  //     $_SESSION['email'] = $row['EmailAddress'];
  //     $_SESSION['fname'] = $row['FirstName'];
  //     $_SESSION['lname'] = $row['LastName'];
  //     $_SESSION['picture'] = $row['ProfilePicture'];
  //     $_SESSION['accountType'] = $row['AccountType'];
  //   }
  // }
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
  <head>
    <title>Northwood Hotel</title>
		<link rel='shortcut icon' href='/favicon.ico'/>
		<?php 
			require_once 'files/meta.php';
			echo "\n";
			foreach (glob(__DIR__."/css/required/*.css") as $css) {
				$file = str_replace(__DIR__, "", $css);
				echo "<link type='text/css' rel='stylesheet' href='$file?v=" . filemtime($css) . "'>\n";
			}
			if (strpos($_SERVER['PHP_SELF'],"admin")) {
				echo "<link type='text/css' rel='stylesheet' href='/css/admin.css?v=".filemtime(__DIR__."/css/admin.css")."'>\n";
			} else {
				echo "<link type='text/css' rel='stylesheet' href='/css/main.css?v=".filemtime(__DIR__."/css/main.css")."'>\n";
			}
			if (file_exists(__DIR__."/css/$currentDirectory.css") && $currentDirectory != 'admin') {
				echo "<link type='text/css' rel='stylesheet' href='/css/$currentDirectory.css?v=".filemtime(__DIR__."/css/$currentDirectory.css")."'>\n";
			}
			if (strpos($_SERVER['PHP_SELF'],"admin")) {
				echo "<link type='text/css' rel='stylesheet' href='/css/pace-theme-minimal.css?v=".filemtime(__DIR__.'/css/pace-theme-minimal.css') . "'>\n";
			} else {
				echo "<link type='text/css' rel='stylesheet' id='pace' href='/css/pace-theme-center-simple.css?v=".filemtime(__DIR__.'/css/pace-theme-center-simple.css') . "'>\n";
			}
		?>
	</head>
  <body>
  <?php
    if (!strpos($_SERVER['PHP_SELF'],"admin")) {
      echo "<div class='loadingIcon'></div>";
      echo "<div style='height:70px'></div>";
			echo "<a href='#' class='back-to-top'>Back to Top</a>";
    }
  ?>
	<div id="alertBox" style="display:none"></div>