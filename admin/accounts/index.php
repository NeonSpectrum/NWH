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
<div id="wrapper">
	<div class="overlay"></div>
	<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
		<ul class="nav sidebar-nav">
			<li class="sidebar-brand">
				<a class="navbar-brand" href="/nwh/" style="line-height:40px">Northwood Hotel</a>
			</li>
			<li>
				<a href="../">Overview</a>
			</li>
			<li style="background-color: #79aefe;">
				<a href="javascript:void(0)">Accounts</a>
			</li>
			<li>
				<a href="../database">Database</a>
			</li>
			<li>
				<a href="../reservation">Reservation</a>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li class="firstdropdownmenu"><a href="../amenities">Amenities</a></li>
					<li><a href="../services">Services</a></li>
					<li><a href="../transactions">Transactions</a></li>
				</ul>
			</li>
			<li>
				<a href="/nwh/login/checkLogout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
			</li>
		</ul>
	</nav>
	<h2 style="text-align:center">Account Management</h2>
	<div id="page-content-wrapper" style="padding-top:0px;">
		<button type="button" class="hamburger is-closed" data-toggle="offcanvas">
			<span class="hamb-top"></span>
			<span class="hamb-middle"></span>
			<span class="hamb-bottom"></span>
		</button>
		<div class="well center-block" style="width:30%">
			<form id="frmAccount">
				<div id="lblErrorDisplayAccount">
					<!-- error will be shown here ! -->
				</div>
				Email Address: <select id="cmbEmail" name="cmbEmail" class="form-control">
					<option></option>
					<?php
						$query = "SELECT * FROM account";
						$result = mysqli_query($db,$query) or die(mysql_error());
						while($row=mysqli_fetch_assoc($result))
						{                                                 
							echo "<option value='".$row['EmailAddress']."'>".$row['EmailAddress']."</option>\n";
						}
					?>
				</select>
				<br/> 
				Account Type: <select id="cmbAccountType" name="cmbAccountType" class="form-control">
					<option></option>
					<option>User</option>
					<option>Admin</option>
					<option>Owner</option>
				</select>
				<br/>
				Profile Picture: <input type="text" id="txtProfilePicture" name="txtProfilePicture" class="form-control" required>
				<br/>
				First Name: <input type="text" id="txtFirstName" name="txtFirstName" class="form-control" required>
				<br/>
				Last Name: <input type="text" id="txtLastName" name="txtLastName" class="form-control" required>
				<br/>
				<div class="text-right">
					<button id="btnEdit" type="submit" class="btn btn-primary" onclick="submitEditForm();return false;">Edit</button>
					<button id="btnDelete" type="submit" class="btn btn-primary" onclick="submitDeleteForm();return false;">Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php require '../../files/footer.php';?>