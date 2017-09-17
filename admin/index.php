<?php 
  session_start();
  if($_SESSION['accounttype']!="Owner")
  {
    header('location: ../home');
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<title>Northwood Hotel</title>
  		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
      <?php 
        require '../files/db.php';
        require '../files/css_required.php';
      ;?>
	</head>
	<body>
    <div class="se-pre-con"></div>
    <div id="wrapper">
    <div class="overlay"></div>
      <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
        <ul class="nav sidebar-nav">
          <li class="sidebar-brand">
            <a class="navbar-brand" href="../" style="line-height:40px">Northwood Hotel</a>
          </li>
          <li>
              <a href="#">Overview</a>
          </li>
          <li>
              <a href="#">Accounts</a>
          </li>
          <li>
              <a href="#">Database</a>
          </li>
          <li>
              <a href="#">Reservation</a>
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
              <a href="<?php $link = '../'; echo '../login/logout.php';?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
          </li>
        </ul>
      </nav>
      <div id="page-content-wrapper">
        <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
          <span class="hamb-top"></span>
          <span class="hamb-middle"></span>
          <span class="hamb-bottom"></span>
        </button>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <h1>Welcome, <?php echo $_SESSION['fname'].' '.$_SESSION['lname'];?><br/><br/>to the<br/><br/>Admin Page<br/><br/>of<br/><br/>Northwood Hotel</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require '../files/script_required.php';?>
	</body>
</html>