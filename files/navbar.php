<?php
	include 'active.php';
?>
<nav class="navbar navbar-default <?php if(!$home) echo 'navbar-fixed-top'?>">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="./"><img src="/nwh/favicon.ico" width="30px" style="float:left;margin-right:10px;margin-top:-4px;" class="white-border"/>Northwood Hotel</a>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li <?php echo $home;?>><a href="<?php echo $home=='' ? '/nwh/home' : 'javascript:void(0)';?>">Home</a></li>
					<li <?php echo $gallery;?>><a href="<?php echo $gallery=='' ? '/nwh/gallery' : 'javascript:void(0)';?>">Gallery</a></li>
					<li <?php echo $rates;?>><a href="<?php echo $rates=='' ? '/nwh/rates' : 'javascript:void(0)';?>">Room & Rates</a></li>
					<li <?php echo $food;?>><a href="<?php echo $food=='' ? '/nwh/foodanddrinks' : 'javascript:void(0)';?>">Food & Drinks</a></li>
					<li class="dropdown <?php echo $amenities;?>" style="cursor:pointer">
						<a class="dropdown-toggle" data-toggle="dropdown">Amenities
						<span class="caret"></span></a>
						<ul class="dropdown-menu" style="color:white">
								<li><a href="/nwh/amenities/function">Function Room</a></li>
								<li><a href="/nwh/amenities/pool">Swimming Pool</a></li>
								<li><a href="/nwh/amenities/bigbite">BigBite Restaurant</a></li>
						</ul>
					</li>
					<li <?php echo $contact;?>><a href="<?php echo $contact=='' ? '/nwh/contactus' : 'javascript:void(0)';?>">Contact Us</a></li>
				</ul>
				<?php include $root.'../login/login.php';?>
		</div>
	</div>
</nav>