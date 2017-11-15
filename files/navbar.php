<?php
  $home = $gallery = $rates = $food = $amenities = $contact = '';
  if(strpos($_SERVER['PHP_SELF'],'home')){
    $home = 'class="active"';
  }
  elseif(strpos($_SERVER['PHP_SELF'],'gallery')){
    $gallery = 'class="active"';
  }
  elseif(strpos($_SERVER['PHP_SELF'],'rates')){
    $rates = 'class="active"';
  }
  elseif(strpos($_SERVER['PHP_SELF'],'foodanddrinks')){
    $food = 'class="active"';
  }
  elseif(strpos($_SERVER['PHP_SELF'],'amenities')){
    $amenities = 'active';
  }
  elseif(strpos($_SERVER['PHP_SELF'],'contactus')){
    $contact = 'class="active"';
  }
?>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/nwh/"><img src="/nwh/favicon.ico" width="30px" style="float:left;margin-right:10px;margin-top:-4px;" class="white-border"/>Northwood Hotel</a>
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
        <li <?php echo $rates;?>><a href="<?php echo $rates=='' ? '/nwh/roomandrates' : 'javascript:void(0)';?>">Room & Rates</a></li>
        <li <?php echo $food;?>><a href="<?php echo $food=='' ? '/nwh/foodanddrinks' : 'javascript:void(0)';?>">Food & Drinks</a></li>
        <li class="dropdown <?php echo $amenities;?>" style="cursor:pointer">
          <a class="dropdown-toggle" data-toggle="dropdown">Amenities<span class="caret"></span></a>
          <ul class="dropdown-menu" style="margin-top:-1px;margin-left:-1px">
              <li><a href="/nwh/amenities/function">Function Room</a></li>
              <li><a href="/nwh/amenities/pool">Swimming Pool</a></li>
              <li><a href="/nwh/amenities/bigbite">BigBite Restaurant</a></li>
          </ul>
        </li>
        <li <?php echo $contact;?>><a href="<?php echo $contact=='' ? '/nwh/contactus' : 'javascript:void(0)';?>">Contact Us</a></li>
      </ul>
      <?php require $root.'../login/login.php';?>
    </div>
  </div>
</nav>