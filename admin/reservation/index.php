<?php 
	$root = '../';
	$adminPage=true;
	require '../../files/header.php';
	if($_SESSION['accountType']=='User' || !isset($_SESSION['accountType']))
	{
		header('location: ../../home');
		exit();
	}
?>
<?php require '../sidebar.php';?>
<h2 class="text-center">Reservation</h2>
<?php include './table.php'?>
<?php require '../../files/footer.php';?>