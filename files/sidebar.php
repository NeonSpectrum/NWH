<?php
  $overview = $accounts = $roommanagement = $reservation = $reports = $amenities = $services = $transactions = '';
  if (strpos($_SERVER['PHP_SELF'],'accounts')){
    $accounts = 'style="background-color: #79aefe;"';
  } elseif (strpos($_SERVER['PHP_SELF'],'roommanagement')) {
    $roommanagement = 'style="background-color: #314190;"';
  } elseif (strpos($_SERVER['PHP_SELF'],'reports')) {
    $reports = 'style="background-color: #7d5d81"';
  } elseif (strpos($_SERVER['PHP_SELF'],'reservation')) {
    $reservation = 'style="background-color: #279636;"';
  } elseif (strpos($_SERVER['PHP_SELF'],'amenities')) {
    $amenities = 'style="background-color: #E100FF;"';
  } elseif (strpos($_SERVER['PHP_SELF'],'services')) {
    $services = 'style="background-color: #2d2366;"';
  } elseif (strpos($_SERVER['PHP_SELF'],'transactions')) {
    $transactions = 'style="background-color: #35acdf;"';
  } elseif (strpos($_SERVER['PHP_SELF'],'admin')) {
    $overview = 'style="background-color: #ec1b5a;"';
  }
?>
<div id="wrapper">
  <div class="overlay"></div>
  <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
    <ul class="nav sidebar-nav">
      <li class="sidebar-brand">
        <a class="navbar-brand" href="<?php echo $root;?>/" style="line-height:40px">Northwood Hotel</a>
      </li>
      <li <?php echo $overview;?>>
        <a href="<?php echo $overview=='' ? "$root/admin" : 'javascript:void(0)';?>">Overview</a>
      </li>
      <li <?php echo $accounts;?>>
        <a href="<?php echo $accounts=='' ? "$root/admin/accounts" : 'javascript:void(0)';?>">Accounts</a>
      </li>
      <li <?php echo $roommanagement;?>>
        <a href="<?php echo $roommanagement=='' ? "$root/admin/roommanagement" : 'javascript:void(0)';?>">Room Management</a>
      </li>
      <li <?php echo $reservation;?>>
        <a href="<?php echo $reservation=='' ? "$root/admin/reservation" : 'javascript:void(0)';?>">Reservation</a>
      </li>
      <li class="dropdown" <?php echo $reports;?>>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li <?php echo $amenities;?> class="firstdropdownmenu"><a href="<?php echo $amenities=='' ? '/admin/amenities' : 'javascript:void(0)';?>">Amenities</a></li>
          <li <?php echo $services;?>><a href="<?php echo $services=='' ? '/admin/services' : 'javascript:void(0)';?>">Services</a></li>
          <li <?php echo $transactions;?>><a href="<?php echo $transactions=='' ? '/admin/transactions' : 'javascript:void(0)';?>">Transactions</a></li>
        </ul>
      </li>
      <li>
        <a href="<?php echo $root;?>/files/checkLogout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
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