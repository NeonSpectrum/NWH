<?php
$fname       = isset($_SESSION["fname"]) ? $_SESSION["fname"] : '';
$lname       = isset($_SESSION["lname"]) ? $_SESSION["lname"] : '';
$picture     = isset($_SESSION["picture"]) ? $_SESSION["picture"] : '';
$accounttype = isset($_SESSION["accountType"]) ? $_SESSION["accountType"] : '';
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo $root; ?>"><img src="<?php echo $root; ?>images/logo-rendered.png?v=<?php echo filemtime(__DIR__."/../images/logo-rendered.png"); ?>" width="200px" style="float:left;margin-left:40px;margin-top:-5px;"/></a>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" style="margin-top:20px">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right" style="margin-top:12px">
        <li class="dropdown">
          <button class="btn btn-danger" style="margin-top:7px;border-radius:0px" data-toggle="dropdown">BOOK NOW</button>
          <ul class="dropdown-menu book-dropdown" style="margin-top:10px;margin-left:-1px;padding:10px 20px 0px 20px">
            <form class="form frmBookCheck" method="post">
              <div class="form-group">
                <label>Check In Date:</label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  <input id="txtCheckInDate" type="text" class="form-control checkInDate" name="txtCheckInDate" required readonly>
                </div>
              </div>
              <div class="form-group">
                <label>Check Out Date:</label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  <input id="txtCheckOutDate" type="text" class="form-control checkOutDate" name="txtCheckOutDate" required readonly>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label>Adults:</label>
                    <input id="txtAdults" type="number" class="form-control" name="txtAdults" onkeypress="return disableKey(event,'letter')" value="1" min="1" max="10" required>
                  </div>
                  <div class="col-md-6">
                    <label>Children:</label>
                    <input id="txtChildren" type="number" class="form-control" name="txtChildren" onkeypress="return disableKey(event,'letter')" value="0" min="0" max="10" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <button id="btnCheck" type="submit" class="btn btn-primary btn-block" <?php echo !isset($_SESSION['email']) ? 'disabled' : ''; ?>><?php echo isset($_SESSION['email']) ? 'Book Now' : 'Login First!'; ?></button>
              </div>
            </form>
          </ul>
        </li>
        <li class="dropdown">
          <a style="cursor:pointer" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-menu-hamburger"></span><b> MENU </b><span class="caret"></span></a>
          <ul class="dropdown-menu" style="margin-top:-1px;margin-left:-1px">
            <li><a href="<?php echo $root; ?>">Home</a></li>
            <li><a href="<?php echo $root; ?>gallery">Gallery</a></li>
            <li><a href="<?php echo $root; ?>roomandrates">Room & Rates</a></li>
            <li><a href="<?php echo $root; ?>contactus">Contact Us</a></li>
          </ul>
        </li>
<?php
if (!isset($_SESSION['email'])) {
  ?>
        <li class="dropdown">
          <!-- <a data-toggle="dropdown" style="cursor:pointer;user-select:none;position:fixed;left:2%;top:25%;z-index:10;background-color:white;padding:200px;font-size:300px">LOGIN</a> -->
          <a style="cursor:pointer" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in"></span><b> LOGIN </b><span class="caret"></span></a>
          <ul class="dropdown-menu login-dropdown" style="padding:20px 20px 0px 20px">
            <div class="row">
              <div class="col-md-12">
                <form id="frmLogin">
                  <div class="lblDisplayError">
                    <!-- error will be shown here ! -->
                  </div>
                  <div class="form-group">
                    <label class="sr-only">Email address</label>
                    <div class="input-group">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                      <input id="txtEmail" type="email" class="form-control" name="txtEmail" placeholder="Email address" required autofocus>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="sr-only">Password</label>
                    <div class="input-group">
                      <span class="input-group-addon"><span class="fa fa-key"></span></span>
                      <input id="txtPassword" type="password" class="form-control" name="txtPassword" placeholder="Password" onkeypress="capsLock(event);" required>
                    </div>
                    <div id="caps" style="display:none;margin-top:4px;margin-left:2px;">Caps Lock is on.</div>
                    <!-- <div class="checkbox">
                      <label>
                        <input type="checkbox" name="cbxRemember" checked> Keep me logged-in
                      </label>
                    </div> -->
                  </div>
                  <div class="form-group">
                    <button id="btnLogin" type="submit" class="btn btn-primary btn-block">Sign in</button>
                    <button class="btn btn-default btn-block" type="button" data-toggle="modal" data-target="#modalRegistration">Register</button>
                  <div class="text-right" style="margin-top:10px"><a style="cursor:pointer;font-size:13px;padding-right:5px" data-toggle="modal" data-target="#modalForgot">Forgot password?</a></div>
                  </div>
                </form>
              </div>
            </div>
          </ul>
        </li>
<?php
} else {
  ?>
        <li class="dropdown">
          <a style="cursor:pointer" class="dropdown-toggle" data-toggle="dropdown">
            <div class="user-icon-navbar" style="background-image: url('<?php echo $root; ?>images/profilepics/<?php echo $picture;
  echo "?v=".filemtime(__DIR__."/../images/profilepics/$picture"); ?>');background-position:center;"></div>
            <div class="user-name-navbar">
              <?php echo "$fname $lname"; ?>
            </div>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" style="color:white;width:200px;margin-top:-1px;margin-right:-1px;">
<?php
if ($accounttype == "Owner" || $accounttype == "Admin") {
    echo "<li><a href='{$root}admin/'>Admin Configuration</a></li>\n";
  }
  ?>
            <li><a style="cursor:pointer" data-toggle="modal" data-target="#modalEditReservation">Edit Reservation</a></li>
            <li><a style="cursor:pointer" data-toggle="modal" data-target="#modalEditProfile">Edit Profile</a></li>
            <li><a style="cursor:pointer" data-toggle="modal" data-target="#modalChange">Change Password</a></li>
            <li><a href="<?php echo $root; ?>account/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>
        </li>
<?php
}
?>
      </ul>
    </div>
  </div>
</nav>
<?php
if (!isset($_SESSION['email'])) {
  ?>
<div id="modalRegistration" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Registration</h4>
      </div>
      <div class="modal-body">
        <form id="frmRegister" class="form-horizontal">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="row" style="margin:0">
            <div class="col-md-6" style="padding-right:25px">
              <div class="form-group">
                <label>First Name<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user-o"></span></span>
                  <input type="text" name="txtFirstName" id="txtFirstName" class="form-control" required autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label>Last Name<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user-o"></span></span>
                  <input type="text" name="txtLastName" id="txtLastName" class="form-control" required autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label>Birth Date<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                  <input type="text" name="txtBirthDate" id="txtBirthDate" class="form-control datepicker" required readonly autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label>Contact Number<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-mobile"></span></span>
                  <input type="text" name="txtContactNumber" id="txtContactNumber" class="form-control" required autocomplete="off">
                </div>
              </div>
            </div>
            <div class="col-md-6" style="padding-left:25px">
              <div class="form-group">
                <label>Email Address<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-envelope-o"></span></span>
                  <input type="email" name="txtEmail" id="txtEmail" class="form-control" required autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label>Password<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-key"></span></span>
                  <input type="password" name="txtPassword" id="txtPassword" class="form-control" required autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label>Verify Password<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-key"></span></span>
                  <input type="password" name="txtRetypePassword" id="txtRetypePassword" class="form-control" required autocomplete="off">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div style="margin-bottom: 10px" class="g-recaptcha pull-left" data-callback="recaptchaCallback" data-expired-callback="expiredCallback" data-sitekey="6Ler0DUUAAAAAK0dRPfLXX4i3HXRKZCmvdLzyRDp"></div>
            <button id="btnRegister" type="submit" class="btn btn-info" disabled>Register</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
   </div>
</div>
<div id="modalForgot" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Forgot Password</h4>
      </div>
      <div class="modal-body">
        <form id="frmForgot" method="post" class="form-horizontal">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input name="txtEmail" type="email" class="form-control" id="txtEmail" placeholder="Email" required/>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnReset" type="submit" class="btn btn-info">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
   </div>
</div>
<?php
} else {
  ?>
<div id="modalChange" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Change Password</h4>
      </div>
      <div class="modal-body">
        <form id="frmChange" method="post" class="form-horizontal">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="form-group">
            <label for="oldpass" class="col-sm-3 control-label">Old Password</label>
            <div class="col-sm-8">
              <input name="txtOldPass" type="password" class="form-control" id="txtOldPass" placeholder="Old Password" minlength="8" required/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">New Password</label>
            <div class="col-sm-8">
              <input name="txtNewPass" type="password" class="form-control" id="txtNewPass" placeholder="New Password" minlength="8" required/>
              <input name="txtRetypeNewPass" type="password" style="margin-top:15px" class="form-control" id="txtRetypeNewPass" placeholder="Retype New Password" minlength="8" required/>
            </div>
          </div>

          <div class="modal-footer">
            <button id="btnUpdate" type="submit" class="btn btn-info">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
   </div>
</div>
<div id="modalEditProfile" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Edit Profile</h4>
      </div>
      <div class="modal-body">
        <form id="frmEditProfile" method="post" class="form-horizontal" enctype="multipart/form-data">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Profile Picture</label>
            <div class="col-sm-8">
              <input type="file" class="form-control" name="imgProfilePic" id="imgProfilePic" accept="image/x-png,image/gif,image/jpeg" onchange="ValidateSingleInput(this);">
            </div>
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-8">
              <div class="row">
                <div class="col-md-6">
                  <input name="txtFirstName" type="text" class="form-control" placeholder="First Name" value="<?php echo $_SESSION['fname']; ?>" required />
                </div>
                <div class="col-md-6">
                  <input name="txtLastName" type="text" class="form-control" placeholder="Last Name"value="<?php echo $_SESSION['lname']; ?>" required/>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnEditProfile" type="submit" class="btn btn-info">Edit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="modalEditReservation" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Edit Reservation</h4>
      </div>
      <div class="modal-body">
        <form id="frmEditReservation" method="post" class="form-horizontal">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Booking ID</label>
            <div class="col-sm-2">
              <select class="form-control" id="cmbBookingID" name="cmbBookingID">
<?php
$email    = $_SESSION['email'];
  $query    = "SELECT * FROM booking WHERE EmailAddress = '$email'";
  $result   = mysqli_query($db, $query) or die(mysql_error());
  $roomID   = $checkInDate   = $checkOutDate   = '';
  $adults   = 1;
  $children = 0;
  $first    = true;
  while ($row = mysqli_fetch_assoc($result)) {
    $tomorrow = time() + 86400; // +1 day
    if ($tomorrow < strtotime($row['CheckInDate'])) {
      if ($first) {
        $roomID       = $row['RoomID'];
        $checkInDate  = $row['CheckInDate'];
        $checkOutDate = $row['CheckOutDate'];
        $adults       = $row['Adults'];
        $children     = $row['Children'];
        $first        = false;
      }
      echo "                ";
      echo "<option value='".$row['BookingID']."'>".$row['BookingID']."</option>\n";
    }
  }
  ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Room Type</label>
            <div class="col-sm-7">
              <select id="cmbRoomType" name="cmbRoomType" class="form-control">
                <option>Standard Single</option>
                <option>Standard Double</option>
                <option>Family Room</option>
                <option>Junior Suites</option>
                <option>Studio Type</option>
                <option>Barkada Room</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Check In Date</label>
            <div class="col-sm-7">
              <div class="input-group date">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input name="txtCheckInDate" type="text" class="form-control checkInDate" id="txtCheckInDate" value="<?php echo $checkInDate; ?>" required readonly/>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Check Out Date</label>
            <div class="col-sm-7">
              <div class="input-group date">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input name="txtCheckOutDate" type="text" class="form-control checkOutDate" id="txtCheckOutDate" value="<?php echo $checkOutDate; ?>" required readonly/>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Adults</label>
            <div class="col-sm-3">
              <input name="txtAdults" type="number" class="form-control" id="txtAdults" placeholder="Adults" value="<?php echo $adults; ?>" onkeypress="disableKey(event,'letter');" min="1" max="10" value="1" required/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Children</label>
            <div class="col-sm-3">
              <input name="txtChildren" type="number" class="form-control" id="txtChildren" placeholder="Children" value="<?php echo $children; ?>" onkeypress="return disableKey(event,'letter');" min="0" max="10" value="0" required/>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnPrint" type="button" class="btn btn-info" onclick="location.href='<?php echo $root; ?>files/generateReservationConfirmation.php?BookingID='+$('#cmbBookingID').val()" disabled>Print</button>
            <button id="btnReservation" type="submit" class="btn btn-info" disabled>Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
   </div>
</div>
<?php
}
?>