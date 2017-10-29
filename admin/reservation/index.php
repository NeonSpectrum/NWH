<?php 
	$root = '../';
	$adminPage=true;
	require $root.'/../files/header.php';
	if($_SESSION['accountType']=='User' || !isset($_SESSION['accountType']))
	{
		header('location: ../../home');
		exit();
	}
?>
<?php require '../sidebar.php';?>
<h2 class="text-center">Reservation</h2>
<?php require 'table.php'?>
<?php require $root.'/../files/footer.php';?>