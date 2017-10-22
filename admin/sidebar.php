<?php
	$overview = $accounts = $database = $reservation = $reports = $amenities = $services = $transactions = '';
	if(strpos($_SERVER['PHP_SELF'],'accounts')){
		$accounts = 'style="background-color: #79aefe;"';
	}
	elseif(strpos($_SERVER['PHP_SELF'],'database')){
		$database = 'style="background-color: #314190;"';
	}
	elseif(strpos($_SERVER['PHP_SELF'],'reports')){
		$reports = 'style="background-color: #7d5d81"';
	}
	elseif(strpos($_SERVER['PHP_SELF'],'reservation')){
		$reservation = 'style="background-color: #279636;"';
	}
	elseif(strpos($_SERVER['PHP_SELF'],'amenities')){
		$amenities = 'style="background-color: #E100FF;"';
	}
	elseif(strpos($_SERVER['PHP_SELF'],'services')){
		$services = 'style="background-color: #2d2366;"';
	}
	elseif(strpos($_SERVER['PHP_SELF'],'transactions')){
		$transactions = 'style="background-color: #35acdf;"';
	}
	elseif(strpos($_SERVER['PHP_SELF'],'admin')){
		$overview = 'style="background-color: #ec1b5a;"';
	}
?>
<div id="wrapper">
	<div class="overlay"></div>
	<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
		<ul class="nav sidebar-nav">
			<li class="sidebar-brand">
				<a class="navbar-brand" href="/nwh/" style="line-height:40px">Northwood Hotel</a>
			</li>
			<li <?php echo $overview;?>>
				<a href="/nwh/admin">Overview</a>
			</li>
			<li <?php echo $accounts;?>>
				<a href="/nwh/admin/accounts">Accounts</a>
			</li>
			<li <?php echo $database;?>>
				<a href="/nwh/admin/database">Database</a>
			</li>
			<li <?php echo $reservation;?>>
				<a href="/nwh/admin/reservation">Reservation</a>
			</li>
			<li class="dropdown" <?php echo $reports;?>>
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li <?php echo $amenities;?> class="firstdropdownmenu"><a href="../amenities">Amenities</a></li>
					<li <?php echo $services;?>><a href="/nwh/admin/services">Services</a></li>
					<li <?php echo $transactions;?>><a href="/nwh/admin/transactions">Transactions</a></li>
				</ul>
			</li>
			<li>
				<a href="/nwh/login/checkLogout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
			</li>
		</ul>
	</nav>
	<div id="page-content-wrapper" style="padding-top:0px;">
		<button type="button" class="hamburger is-closed" data-toggle="offcanvas">
			<span class="hamb-top"></span>
			<span class="hamb-middle"></span>
			<span class="hamb-bottom"></span>
		</button>
	</div>
</div>