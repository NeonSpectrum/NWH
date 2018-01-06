<?php
require_once "../header.php";
?>
<div class="panel panel-default center-block" style="width:30%;border-radius:0">
  <div class="panel-heading" style="background-color:inherit"><h1 style="text-align:center">Login Page</h1></div>
  <div class="panel-body center-block" style="width:90%">
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
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
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
                  <input type="text" name="txtFirstName" id="txtFirstName" class="form-control" pattern="[a-zA-Z ]*$" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Last Name<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user-o"></span></span>
                  <input type="text" name="txtLastName" id="txtLastName" class="form-control" pattern="[a-zA-Z ]*$" required autocomplete="off">
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
          <div style="margin-bottom: 10px" class="g-recaptcha pull-left" data-callback="recaptchaCallback" data-expired-callback="expiredCallback" data-sitekey="6Ler0DUUAAAAAK0dRPfLXX4i3HXRKZCmvdLzyRDp"></div>
          <button id="btnRegister" type="submit" class="btn btn-info" disabled>Register</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
require_once "../footer.php";
?>