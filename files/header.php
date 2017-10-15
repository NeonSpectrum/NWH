<?php
	session_start();
	$root = isset($root) ? $root : '';
	$adminPage = isset($adminPage) ? $adminPage : false;
	$home = isset($home) ? $home : false;
	require_once $root.'../files/db.php';
	if(isset($_COOKIE['nwhAuth']))
	{
		parse_str($_COOKIE['nwhAuth']);
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
	<body style="<?php if(!$home && !$adminPage) echo 'padding-top:70px';?>;padding-right:0px !important">
	<?php
		if(!$adminPage)
			echo "<div class='loadingIcon'></div>";
	?>
<!-- 	<div id="modalNotif" class="modal fade" role="dialog" data-backdrop="false" style="height:100px;width:598px;margin: 0 auto;overflow-y:hidden;z-index:9999;">
		<div class="modal-dialog">
			<div class="modal-content" style="border-radius:10px !important">
				<div class="modal-header" id="notifStatus" style="border-bottom:0px;border-radius:10px !important;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-center" id="modalNotifMessage"></h4>
				</div>
			</div>
		</div>
	</div> -->
	<div id="alertBox" style="display:none"></div>