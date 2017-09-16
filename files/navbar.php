<?php include 'active.php'?>
<nav class="navbar navbar-default" data-spy="affix" data-offset-top="650">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="./"><img src="../images/logo.png" width="30px" style="float:left;margin-right:10px"/>Northwood Hotel</a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
    </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li <?php echo $home;?>><a href="/nwh/home">Home</a></li>
          <li <?php echo $gallery;?>><a href="/nwh/gallery">Gallery</a></li>
          <li <?php echo $rates;?>><a href="/nwh/rates">Room & Rates</a></li>
          <li <?php echo $food;?>><a href="/nwh/foodanddrinks">Food & Drinks</a></li>
          <li class="dropdown" <?php echo $amenities;?>>
            <a class="dropdown-toggle" data-toggle="dropdown" href="/nwh/amenities">Amenities
            <span class="caret"></span></a>
            <ul class="dropdown-menu" style="color:white">
                <li><a href="#">Function Room</a></li>
                <li><a href="#">Swimming Pool</a></li>
                <li><a href="#">BigBite Restaurant</a></li>
            </ul>
          </li>
          <li <?php echo $contact;?>><a href="/nwh/contactus">Contact Us</a></li>
        </ul>
        <?php include '../login/login.php';?>
    </div>
	</div>
</nav>