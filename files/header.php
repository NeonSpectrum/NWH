<?php
  session_start();
  $root = isset($root) ? $root : '';
  $adminPage = isset($adminPage) ? $adminPage : false;
  $home = isset($home) ? $home : false;
  require_once $root.'../files/db.php';
  if(isset($_COOKIE['nwhAuth']))
  {
    parse_str($_COOKIE['nwhAuth']);
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
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<title>Northwood Hotel</title>
      <?php 
        require $root.'../files/meta.php';
        require $root.'../files/db.php';
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
	<body style="<?php if(!$home && !$adminPage) echo 'padding-top:70px';?>">
<?php
	if(!$adminPage)
		echo "<div class='loadingIcon'></div>";
?>