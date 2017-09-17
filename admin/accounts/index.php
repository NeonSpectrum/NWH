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
        $links= '../';
        require '../../files/db.php';
        require '../../files/css_required.php';
      ;?>
	</head>
	<body><!-- 
    <div class="se-pre-con"></div> -->
    <div id="wrapper">
    <div class="overlay"></div>
      <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
        <ul class="nav sidebar-nav">
          <li class="sidebar-brand">
            <a class="navbar-brand" href="../" style="line-height:40px">Northwood Hotel</a>
          </li>
          <li>
              <a href="../">Overview</a>
          </li>
          <li style="background-color: #79aefe;">
              <a href="javascript.void(0)">Accounts</a>
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
          <form id="editAccountForm">
            <div id="errorLogin">
              <!-- error will be shown here ! -->
            </div>
            <select id="emailcombobox">
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
            <select id="accounttypecombobox">
              <option></option>
              <option>User</option>
              <option>Admin</option>
              <option>Owner</option>
            </select>
            <input type="text" id="profilepicture" name="profilepicture" required>
            <input type="text" id="firstname" name="firstname" required>
            <input type="text" id="lastname" name="lastname" required>
            <input type="text" id="islogged" name="islogged" required>
            <button id="edit" type="submit" class="btn btn-primary" onclick="submitEditForm();return false;">Submit</button>
          </form>
        </div>
      </div>
    </div>
    <?php require '../../files/script_required.php';?>
	</body>
</html>