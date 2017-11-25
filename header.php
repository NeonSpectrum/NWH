<?php
  session_start(); //this is the login session
  require_once 'files/db.php'; //link to database php
  $requestURI = str_replace("?{$_SERVER['QUERY_STRING']}", "", $_SERVER['REQUEST_URI']);

	if ($requestURI == '/' || $requestURI == '/nwh/') {
    $currentDirectory = 'home';
    $root = '.';
	} else {
    $root = '..';
    if ($requestURI != '/admin/' && $requestURI != '/nwh/admin/' && strpos($requestURI,"admin"))
      $root = '../..';
		$currentDirectory = str_replace("?{$_SERVER['QUERY_STRING']}", "", $_SERVER['REQUEST_URI']);
		$currentDirectory = substr($currentDirectory, 0, -1);
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
		<link rel='shortcut icon' href='<?php echo $root;?>/favicon.ico'/>
		<?php 
			require_once 'files/meta.php';
			echo "\n";
			foreach (glob(__DIR__."/assets/css/required/*.css") as $css) {
				$file = str_replace(__DIR__, "", $css);
				echo "<link type='text/css' rel='stylesheet' href='$root$file?v=" . filemtime($css) . "'>\n";
			}
			if (strpos($_SERVER['PHP_SELF'],"admin")) {
				echo "<link type='text/css' rel='stylesheet' href='$root/assets/css/admin.css?v=".filemtime(__DIR__."/assets/css/admin.css")."'>\n";
			} else {
				echo "<link type='text/css' rel='stylesheet' href='$root/assets/css/main.css?v=".filemtime(__DIR__."/assets/css/main.css")."'>\n";
			}
			if (file_exists(__DIR__."/assets/css/$currentDirectory.css") && $currentDirectory != 'admin') {
				echo "<link type='text/css' rel='stylesheet' href='$root/assets/css/$currentDirectory.css?v=".filemtime(__DIR__."/assets/css/$currentDirectory.css")."'>\n";
			}
			if (strpos($_SERVER['PHP_SELF'],"admin")) {
				echo "<link type='text/css' rel='stylesheet' href='$root/assets/css/pace-theme-minimal.css?v=".filemtime(__DIR__.'/assets/css/pace-theme-minimal.css') . "'>\n";
			} else {
				echo "<link type='text/css' rel='stylesheet' id='pace' href='$root/assets/css/pace-theme-center-simple.css?v=".filemtime(__DIR__.'/assets/css/pace-theme-center-simple.css') . "'>\n";
			}
		?>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	</head>
  <body>
  <?php
    if (!strpos($_SERVER['PHP_SELF'],"admin")) {
      echo "<div class='loadingIcon'></div>";
      if ($requestURI != '/' && $requestURI != '/nwh/')
        echo "<div class='height-navbar'></div>";
			echo "<a href='#' class='back-to-top'>Back to Top</a>";
    }
  ?>
	<div id="alertBox"></div>