<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo $root; ?>"><img src="<?php echo $root; ?>images/logo-rendered.png?v=<?php echo filemtime(__DIR__ . "/../images/logo-rendered.png"); ?>" width="200px" style="float:left;margin-left:40px;margin-top:-5px;"/></a>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" style="margin-top:20px">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right" style="margin-top:12px">
<?php
if (!strpos($_SERVER['PHP_SELF'], "/reservation")) {
  ?>
        <!-- <li class="dropdown">
          <button class="btn btn-danger pulse" style="margin-top:7px;border-radius:0px" data-toggle="dropdown">BOOK NOW</button>
          <ul class="dropdown-menu book-dropdown" style="margin-top:10px;margin-left:-1px;padding:10px 20px 0px 20px">
            <form class="form frmBookCheck">
              <div class="form-group">
                <label>Check Date:</label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  <input id="txtCheckDate" type="text" class="form-control checkDate" name="txtCheckDate" readonly required>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label>Adults:</label>
                    <input id="txtAdults" type="number" class="form-control" name="txtAdults" onkeypress="return disableKey(event,'letter')" value="1" min="1" max="<?php echo MAX_ADULTS; ?>" required>
                  </div>
                  <div class="col-md-6">
                    <label>Children:</label>
                    <input id="txtChildren" type="number" class="form-control" name="txtChildren" onkeypress="return disableKey(event,'letter')" value="0" min="0" max="<?php echo MAX_CHILDREN; ?>" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <button id="btnCheck" type="submit" class="btn btn-primary btn-block">Book Now</button>
              </div>
            </form>
          </ul>
        </li> -->
<?php
}
?>
        <li class="dropdown">
          <a style="cursor:pointer" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-menu-hamburger"></span><b> MENU </b><span class="caret"></span></a>
          <ul class="dropdown-menu" style="margin-top:-1px;margin-left:-1px">
            <li><a href="<?php echo $root; ?>">Home</a></li>
            <li><a href="<?php echo $root; ?>gallery">Gallery</a></li>
            <li><a href="<?php echo $root; ?>roomandrates">Room & Rates</a></li>
<?php
if ($currentDirectory == "home") {
  echo '<li><a style="cursor:pointer" data-toggle="modal" data-target="#modalPromo">Promos</a></li>';
}
?>
            <li><a href="<?php echo $root; ?>contactus">Contact Us</a></li>
          </ul>
        </li>
<?php
if (!$system->isLogged()) {
  ?>
        <li class="dropdown">
          <!-- <a data-toggle="dropdown" style="cursor:pointer;user-select:none;position:fixed;left:2%;top:25%;z-index:10;background-color:white;padding:200px;font-size:300px">LOGIN</a> -->
          <a style="cursor:pointer" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in"></span><b> LOGIN </b><span class="caret"></span></a>
          <ul class="dropdown-menu login-dropdown" style="padding:20px 20px 0px 20px">
            <div class="row">
              <div class="col-md-12">
                <form id="frmLogin">
                  <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>"/>
                  <div class="lblDisplayError">
                    <!-- error will be shown here ! -->
                  </div>
                  <div class="form-group">
                    <label class="sr-only">Email address</label>
                    <div class="input-group">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                      <input id="txtEmail" type="email" class="form-control" name="txtEmail" placeholder="Email address" required autofocus>
                    </div>
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label class="sr-only">Password</label>
                    <div class="input-group">
                      <span class="input-group-addon"><span class="fa fa-key"></span></span>
                      <input type="password" class="form-control" name="txtPassword" placeholder="Password" onkeypress="capsLock(event);" required>
                    </div>
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <div class="help-block with-errors"></div>
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
            <div class="user-icon-navbar" style="background-image: url('<?php echo $root; ?>images/profilepics/<?php echo "{$_SESSION['account']["picture"]}?v=" . filemtime(__DIR__ . "/../images/profilepics/{$_SESSION['account']["picture"]}"); ?>');background-position:center;"></div>
            <div class="user-name-navbar">
              <?php echo "{$_SESSION['account']["fname"]} {$_SESSION['account']["lname"]}"; ?>
            </div>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" style="color:white;width:200px;margin-top:-1px;margin-right:-1px;">
<?php
if ($system->checkUserLevel(1)) {
    echo "<li><a href='{$root}admin/'>Admin Configuration</a></li>\n";
  }
  ?>
            <li><a style="cursor:pointer" data-toggle="modal" data-target="#modalEditReservation">Edit Reservation</a></li>
            <li><a style="cursor:pointer" data-toggle="modal" data-target="#modalEditProfile">Edit Profile</a></li>
            <li><a style="cursor:pointer" data-toggle="modal" data-target="#modalChangePassword">Change Password</a></li>
            <li><a href="<?php echo $root; ?>account?mode=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
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
if (!$system->isLogged()) {
  ?>
<div id="modalRegistration" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Registration</h4>
      </div>
      <form id="frmRegister" data-toggle="validator">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>"/>
        <div class="modal-body">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="row">
            <div class="col-md-12">
              <b>Note:</b> You must verify the email address to register your account.
              <br/>
              <br/>
            </div>
            <div class="col-md-6">
              <div class="form-group has-feedback">
                <label>First Name<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user-o"></span></span>
                  <input type="text" name="txtFirstName" id="txtFirstName" class="form-control" pattern="[a-zA-Z][a-zA-Z ]+" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Last Name<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user-o"></span></span>
                  <input type="text" name="txtLastName" id="txtLastName" class="form-control" pattern="[a-zA-Z][a-zA-Z ]+" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Birth Date<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                  <input type="text" name="txtBirthDate" id="txtBirthDate" class="form-control birthDate" placeholder="mm/dd/yyyy" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Contact Number<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-mobile fa-lg"></span></span>
                  <input type="text" name="txtContactNumber" id="txtContactNumber" class="form-control" pattern="[0-9]*$" onkeypress="return disableKey(event,'letter');" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-feedback">
                <label>Email Address<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-envelope-o"></span></span>
                  <input type="email" name="txtEmail" id="txtEmail" class="form-control" data-error="<?php echo REGISTER_EMAIL_ERROR; ?>" data-remote="<?php echo $root; ?>account?mode=checkEmail" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Password<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-key"></span></span>
                  <input type="password" name="txtPassword" id="txtPassword" class="form-control" minlength="8" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Verify Password<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-key"></span></span>
                  <input type="password" name="txtRetypePassword" id="txtRetypePassword" class="form-control" minlength="8" data-match="#txtPassword" data-match-error="Whoops, these don't match" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
<?php
if (VERIFY_REGISTER) {
    ?>
          <div style="margin-bottom: 10px" class="g-recaptcha pull-left" data-callback="recaptchaCallback" data-expired-callback="expiredCallback" data-sitekey="6Ler0DUUAAAAAK0dRPfLXX4i3HXRKZCmvdLzyRDp"></div>
<?php
}
  ?>
          <button id="btnRegister" type="submit" class="btn btn-info"<?php echo !VERIFY_REGISTER ? "" : " disabled"; ?>>Register</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="modalForgot" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Forgot Password</h4>
      </div>
      <form id="frmForgot" class="form-horizontal">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>"/>
        <div class="modal-body">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input name="txtEmail" type="email" class="form-control" id="txtEmail" placeholder="Email" required/>
            </div>
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
<?php
} else if (!$db->connect_error) {
  ?>
<div id="modalChangePassword" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Change Password</h4>
      </div>
      <form id="frmChange" class="form-horizontal">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>"/>
        <div class="modal-body">
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
        </div>
        <div class="modal-footer">
          <button id="btnUpdate" type="submit" class="btn btn-info">Update</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
   </div>
</div>
<div id="modalEditProfile" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Edit Profile</h4>
      </div>
      <form id="frmEditProfile" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>"/>
        <div class="modal-body">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="row">
            <div class="col-md-9">
              <div class="form-group">
                <label>Profile Picture</label>
                <input type="file" class="form-control" name="imgProfilePic" id="imgProfilePic" onchange="readPicture(this);" accept="image/x-png,image/gif,image/jpeg" onchange="ValidateSingleInput(this);">
              </div>
            </div>
            <div class="col-md-3">
              <div class="center-block" style="border:1px solid #ccc;height:102px;width:102px;">
                <img id="displayImage" height="102" width="102" src="<?php echo $root; ?>images/profilepics/<?php echo "{$_SESSION['account']["picture"]}?v=" . filemtime(__DIR__ . "/../images/profilepics/{$_SESSION['account']["picture"]}") ?>" style="object-fit: cover"/>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>First Name<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user-o"></span></span>
                  <input type="text" name="txtFirstName" id="txtFirstName" class="form-control" value="<?php echo $_SESSION['account']['fname']; ?>" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group">
                <label>Last Name<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user-o"></span></span>
                  <input type="text" name="txtLastName" id="txtLastName" class="form-control" value="<?php echo $_SESSION['account']['lname']; ?>" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Birth Date<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                  <input type="text" name="txtBirthDate" id="txtBirthDate" class="form-control birthDate" value="<?php echo date("m/d/Y", strtotime($_SESSION['account']['birthDate'])); ?>" required readonly autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group">
                <label>Contact Number<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-mobile fa-lg"></span></span>
                  <input type="text" name="txtContactNumber" id="txtContactNumber" class="form-control" value="<?php echo $_SESSION['account']['contactNumber']; ?>" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
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
<div id="modalEditReservation" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Edit Reservation</h4>
      </div>
      <div class="modal-body">
        <form id="frmEditReservation" class="form-horizontal">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label">Booking ID: </label>
                <div class="col-sm-8">
                  <select name="cmbBookingID" class="form-control" id="cmbBookingID">
<?php
$view->listBookingID("combobox");
  ?>
                  </select>
                </div>
              </div>
<?php
$result        = $db->query("SELECT * FROM booking JOIN booking_room ON booking.BookingID=booking_room.BookingID WHERE booking.BookingID=" . ($view->listBookingID() != false ? $view->listBookingID()[0] : 0));
  $row           = $result->fetch_assoc();
  $checkDate     = date("m/d/Y", strtotime($row['CheckInDate'])) . " - " . date("m/d/Y", strtotime($row['CheckOutDate']));
  $checkInDate   = date("m/d/Y", strtotime($row['CheckInDate']));
  $checkOutDate  = date("m/d/Y", strtotime($row['CheckOutDate']));
  $checkDate     = $row['CheckInDate'] == "" && $row['CheckOutDate'] == "" ? date("m/d/Y", strtotime($date) + 86400) . " - " . date("m/d/Y", strtotime($date) + 86400 * 2) : $checkDate;
  $adults        = $row['Adults'];
  $children      = $row['Children'];
  $paymentMethod = $row['PaymentMethod'];
  $roomTypes     = $room->getRoomTypeList();
  $roomQuantity  = array_fill(0, count($roomTypes), 0);

  $result->data_seek(0);
  while ($row = $result->fetch_assoc()) {
    $roomType = $room->getRoomType($row['RoomID']);
    $roomQuantity[array_search($roomType, $roomTypes)]++;
  }
  ?>
              <div class="form-group">
                <label class="col-sm-4 control-label">Check Date: </label>
                <div class="col-sm-8">
                  <div class="input-group date">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    <input name="txtCheckDate" type="text" class="form-control checkDate" id="txtCheckDate" value="<?php echo $checkDate; ?>" readonly required/>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Adults: </label>
                <div class="col-sm-4">
                  <input name="txtAdults" type="number" class="form-control" id="txtAdults" placeholder="Adults" onkeypress="return disableKey(event,'letter');" value="<?php echo $adults; ?>" min="1" max="<?php echo MAX_ADULTS; ?>" required/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Children: </label>
                <div class="col-sm-4">
                  <input name="txtChildren" type="number" class="form-control" id="txtChildren" placeholder="Children" onkeypress="return disableKey(event,'letter');" value="<?php echo $children; ?>" min="0" max="<?php echo MAX_CHILDREN; ?>" required/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Payment Method: </label>
                <div class="col-sm-4">
                  <select name="txtPaymentMethod" class="form-control" id="txtPaymentMethod">
                    <option value="Cash"<?php echo $paymentMethod == "Cash" ? " selected" : ""; ?>>Cash</option>
                    <option value="Bank"<?php echo $paymentMethod == "Bank" ? " selected" : ""; ?>>Bank</option>
                    <option value="PayPal"<?php echo $paymentMethod == "PayPal" ? " selected" : ""; ?>>PayPal</option>
                  </select>
                  <button id='btnPaypal' type='button' class='btn btn-primary' style='margin-top:10px'>Pay now with Paypal</button>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-5 control-label lblRoomType" id='Standard_Single'>Standard Single: </label>
                <div class="col-sm-4">
                  <select class="form-control cmbQuantity">
<?php
$count = count($room->generateRoomID("Standard_Single", null, $checkInDate, $checkOutDate));
  for ($i = 0; $i <= $count + $roomQuantity[0]; $i++) {
    echo "<option value='$i'" . ($roomQuantity[0] == $i ? " selected='selected'" : "") . ">$i</option>";
  }
  ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-5 control-label lblRoomType" id='Standard_Double'>Standard Double: </label>
                <div class="col-sm-4">
                  <select class="form-control cmbQuantity">
<?php
$count = count($room->generateRoomID("Standard_Double", null, $checkInDate, $checkOutDate));
  for ($i = 0; $i <= $count + $roomQuantity[1]; $i++) {
    echo "<option value='$i'" . ($roomQuantity[1] == $i ? " selected='selected'" : "") . ">$i</option>";
  }
  ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-5 control-label lblRoomType" id='Family_Room'>Family Room: </label>
                <div class="col-sm-4">
                  <select class="form-control cmbQuantity">
<?php
$count = count($room->generateRoomID("Family_Room", null, $checkInDate, $checkOutDate));
  for ($i = 0; $i <= $count + $roomQuantity[2]; $i++) {
    echo "<option value='$i'" . ($roomQuantity[2] == $i ? " selected='selected'" : "") . ">$i</option>";
  }
  ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-5 control-label lblRoomType" id='Junior_Suites'>Junior Suites: </label>
                <div class="col-sm-4">
                  <select class="form-control cmbQuantity">
<?php
$count = count($room->generateRoomID("Junior_Suites", null, $checkInDate, $checkOutDate));
  for ($i = 0; $i <= $count + $roomQuantity[3]; $i++) {
    echo "<option value='$i'" . ($roomQuantity[3] == $i ? " selected='selected'" : "") . ">$i</option>";
  }
  ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-5 control-label lblRoomType" id='Studio_Type'>Studio Type: </label>
                <div class="col-sm-4">
                  <select class="form-control cmbQuantity">
<?php
$count = count($room->generateRoomID("Studio_Type", null, $checkInDate, $checkOutDate));
  for ($i = 0; $i <= $count + $roomQuantity[4]; $i++) {
    echo "<option value='$i'" . ($roomQuantity[4] == $i ? " selected='selected'" : "") . ">$i</option>";
  }
  ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-5 control-label lblRoomType" id='Barkada_Room'>Barkada Room: </label>
                <div class="col-sm-4">
                  <select class="form-control cmbQuantity">
<?php
$count = count($room->generateRoomID("Barkada_Room", null, $checkInDate, $checkOutDate));
  for ($i = 0; $i <= $count + $roomQuantity[5]; $i++) {
    echo "<option value='$i'" . ($roomQuantity[5] == $i ? " selected='selected'" : "") . ">$i</option>";
  }
  ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnPrint" type="button" onclick="if($(this).closest('form').find('#cmbBookingID option:selected').html() != '') location.href='//<?php echo $_SERVER['SERVER_NAME'] . $root ?>files/generateReservationConfirmation/?BookingID='+$(this).closest('form').find('#cmbBookingID option:selected').html()" class="btn btn-info" <?php echo $view->listBookingID() == false ? "disabled" : ""; ?>>Print</button>
            <button id="btnUpdate" type="submit" class="btn btn-info" <?php echo $view->listBookingID() == false ? "disabled" : ""; ?>>Update</button>
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