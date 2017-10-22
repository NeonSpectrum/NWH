<?php
	$adminPage = true;
	require '../files/header.php';
	if($_SESSION['accountType']=='User' || !isset($_SESSION['accountType']))
	{
		header('location: ../home');
		exit();
	}
?>
<style>body{overflow-y:hidden}</style>
<div id="wrapper">
<div class="overlay"></div>
	<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
		<ul class="nav sidebar-nav">
			<li class="sidebar-brand">
				<a class="navbar-brand" href="/nwh/" style="line-height:40px">Northwood Hotel</a>
			</li>
			<li style="background-color: #ec1b5a;">
					<a href="javascript:void(0)">Overview</a>
			</li>
			<li>
					<a href="accounts">Accounts</a>
			</li>
			<li>
					<a href="database">Database</a>
			</li>
			<li>
					<a href="reservation">Reservation</a>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li class="firstdropdownmenu"><a href="amenities">Amenities</a></li>
					<li><a href="services">Services</a></li>
					<li><a href="transaction">Transactions</a></li>
				</ul>
			</li>
			<li>
					<a href="/nwh/login/checkLogout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
			</li>
		</ul>
	</nav>
	<div id="page-content-wrapper">
		<button type="button" class="hamburger is-closed" data-toggle="offcanvas">
			<span class="hamb-top"></span>
			<span class="hamb-middle"></span>
			<span class="hamb-bottom"></span>
		</button>
		<div class="well center-block text-center admin-body">
			Welcome, <?php echo $_SESSION['fname'].' '.$_SESSION['lname'];?><br/>to the<br/>Admin Page<br/>of<br/>Northwood Hotel
		</div>
	</div>
</div>
<div style="position:absolute;bottom:5px;right:5px;">
		<button type="submit" class="btn btn-default" id="btnGitUpdate">Update Website</button>
</div>
<?php require '../files/footer.php';?>
<script>
	$('#btnGitUpdate').click(function(){
		$.ajax({
			url  : '/nwh/files/gitUpdate.php',
			success :  function(response)
			{
				alertNotif("success",response,true,3000);
			}
		});
	})
</script>