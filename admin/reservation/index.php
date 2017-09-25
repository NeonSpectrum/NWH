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
      <li>
				<a href="../accounts">Accounts</a>
      </li>
      <li>
				<a href="#">Database</a>
      </li>
      <li style="background-color: #279636;">
				<a href="javascript:void(0)">Reservation</a>
      </li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li class="firstdropdownmenu"><a href="#">Amenities</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">Transactions</a></li>
        </ul>
      </li>
      <li>
        <a href="/nwh/login/checkLogout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
      </li>
    </ul>
  </nav>
  <h2 style="float: left;position: relative;overflow: hidden;left:44%;">Reservation</h2>
  <div id="page-content-wrapper">
    <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
      <span class="hamb-top"></span>
      <span class="hamb-middle"></span>
      <span class="hamb-bottom"></span>
    </button>
    <?php include './table.php'?>
  </div>
</div>
<?php require '../../files/footer.php';?>