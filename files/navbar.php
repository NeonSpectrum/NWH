<?php
  $fname = isset($_SESSION["fname"]) ? $_SESSION["fname"] : '';
  $lname = isset($_SESSION["lname"]) ? $_SESSION["lname"] : '';
  $picture = isset($_SESSION["picture"]) ? $_SESSION["picture"] : '';
  $accounttype = isset($_SESSION["accountType"]) ? $_SESSION["accountType"] : '';
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo $root;?>"><img src="<?php echo $root;?>images/logo-rendered.png" width="200px" style="float:left;margin-left:40px;margin-top:-5px;"/></a>
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
                <input id="txtCheckInDate" type="text" class="form-control checkInDate" name="txtCheckInDate" onkeypress="return disableKey(event,'number')" required>
              </div>
              <div class="form-group">
                <label>Check Out Date:</label>
                <input id="txtCheckOutDate" type="text" class="form-control checkOutDate" name="txtCheckOutDate" onkeypress="return disableKey(event,'number')" required>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label>Adults:</label>
                    <input id="txtAdults" type="number" class="form-control" name="txtAdults" onkeypress="return disableKey(event,'letter')" value="0" min="0" max="10" required>
                  </div>
                  <div class="col-md-6">
                    <label>Children:</label>
                    <input id="txtChildren" type="number" class="form-control" name="txtChildren" onkeypress="return disableKey(event,'letter')" value="0" min="0" max="10" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <button id="btnCheck" type="submit" class="btn btn-primary btn-block" <?php echo !isset($_SESSION['email']) ? 'disabled' : '';?>><?php echo isset($_SESSION['email']) ? 'Book Now' : 'Login First!';?></button>
              </div>
            </form> 
          </ul>
        </li>
        <li class="dropdown">
          <a style="cursor:pointer" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-menu-hamburger"></span><b> MENU </b><span class="caret"></span></a>
          <ul class="dropdown-menu" style="margin-top:-1px;margin-left:-1px">
            <li><a href="<?php echo $root;?>">Home</a></li>
            <li><a href="<?php echo $root;?>gallery">Gallery</a></li>
            <li><a href="<?php echo $root;?>roomandrates">Room & Rates</a></li>
            <li><a href="<?php echo $root;?>contactus">Contact Us</a></li>
          </ul>
        </li>
<?php
  if (!isset($_SESSION['email']))
  {
?>
        <li class="dropdown">
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
                    <input id="txtEmail" type="email" class="form-control" name="txtEmail" placeholder="Email address" required autofocus>
                  </div>
                  <div class="form-group">
                    <label class="sr-only">Password</label>
                    <input id="txtPassword" type="password" class="form-control" name="txtPassword" placeholder="Password" onkeypress="capsLock(event);" required>
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
  }
  else
  {
?>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown">
            <div class="user-icon-navbar" style="background-image: url('<?php echo $root;?>images/profilepics/<?php echo $picture;echo "?v=".filemtime(__DIR__."/../images/profilepics/$picture");?>');background-position:center;"></div>
            <div class="user-name-navbar">
              <?php echo "$fname $lname";?>
            </div>
	          <span class="caret"></span>
		      </a>
          <ul class="dropdown-menu" style="color:white;width:200px;margin-top:-1px;margin-right:-1px;">
<?php
  if ($accounttype == "Owner" || $accounttype == "Admin")
    echo "<li><a href='{$root}admin/'>Admin Configuration</a></li>\n";
?>
            <li><a data-toggle="modal" data-target="#modalEditReservation">Edit Reservation</a></li>
            <li><a data-toggle="modal" data-target="#modalEditProfile">Edit Profile</a></li>
            <li><a data-toggle="modal" data-target="#modalChange">Change Password</a></li>
            <li><a href="<?php echo $root;?>ajax/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
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
  if (!isset($_SESSION['email']))
  {
?>
<div id="modalRegistration" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Registration</h4>
      </div>
      <div class="modal-body">
        <form id="frmRegister" method="post" class="form-horizontal">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
              <div class="row">
                <div class="col-md-6">
                  <input name="txtFirstName" type="text" class="form-control" placeholder="First Name" required />
                </div>
                <div class="col-md-6">
                  <input name="txtLastName" type="text" class="form-control" placeholder="Last Name" required/>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input name="txtEmail" type="email" class="form-control" id="txtEmail" placeholder="Email" required/>
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
              <input name="txtPassword" type="password" class="form-control" id="txtPassword" placeholder="Password" minlength="8" required/>
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
              <input name="txtRetypePassword" type="password" class="form-control" id="txtRetypePassword" placeholder="Retype Password" minlength="8" required/>
            </div>
          </div>
          <div class="form-group">
            <label for="captcha" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
              <div class="g-recaptcha" style="width:100%" data-callback="recaptchaCallback" data-sitekey="6Ler0DUUAAAAAK0dRPfLXX4i3HXRKZCmvdLzyRDp"></div>
            </div>
          </div>
          <div class="modal-footer">
            <br/><button id="btnRegister" type="submit" class="btn btn-info" disabled>Register</button>
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
  }
  else
  {
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
                  <input name="txtFirstName" type="text" class="form-control" placeholder="First Name" value="<?php echo $_SESSION['fname'];?>" required />
                </div>
                <div class="col-md-6">
                  <input name="txtLastName" type="text" class="form-control" placeholder="Last Name"value="<?php echo $_SESSION['lname'];?>" required/>
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
                <option></option>
                <?php
                  $email = $_SESSION['email'];
                  $query = "SELECT * FROM booking WHERE EmailAddress = '$email'";
                  $result = mysqli_query($db,$query) or die(mysql_error());
                  while ($row=mysqli_fetch_assoc($result)) {
                    $tomorrow = time()+86400; // +1 day
                    $checkInDate = strtotime($row['CheckInDate']);
                    if ($tomorrow < $checkInDate)
                      echo "<option value='".$row['BookingID']."'>".$row['BookingID']."</option>\n";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Room ID</label>
            <div class="col-sm-3">
              <input name="RoomID" type="text" class="form-control" id="RoomID" placeholder="RoomID" required/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Check In Date</label>
            <div class="col-sm-7">
              <input name="CheckInDate" type="date" class="form-control checkInDate" id="CheckInDate" onkeydown="return disableKey(event,'number')" required/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Check Out Date</label>
            <div class="col-sm-7">
              <input name="CheckOutDate" type="date" class="form-control checkOutDate" id="CheckOutDate" onkeydown="return disableKey(event,'number')" required/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Adults</label>
            <div class="col-sm-3">
              <input name="Adults" type="number" class="form-control" id="Adults" placeholder="Adults" onkeypress="disableKey(event,'letter');" min="0" max="10" value="0" required/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Childrens</label>
            <div class="col-sm-3">
              <input name="Childrens" type="number" class="form-control" id="Childrens" placeholder="Childrens" onkeypress="return disableKey(event,'letter');" min="0" max="10" value="0" required/>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnPrint" type="button" class="btn btn-info" onclick="location.href='<?php echo $root;?>/files/generateReservationConfirmation.php?BookingID='+$('#cmbBookingID').val()" disabled>Print</button>
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