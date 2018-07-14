<?php
require_once '../header.php';
if ($account->isLogged()) {
  header("Location: $root");
}
?>
<br/><br/><br/><br/>
<center><img src="../images/logo-rendered.png" width="20%"></center>
<div class="panel panel-default center-block col-md-4" style="float:none;border-radius:0">
  <div class="panel-heading" style="background-color:inherit"><h1 style="text-align:center">Login Page</h1></div>
  <div class="panel-body center-block" style="width:90%">
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
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group has-feedback">
            <label class="sr-only">Password</label>
            <div class="input-group">
              <span class="input-group-addon"><span class="fa fa-key"></span></span>
              <input type="password" class="form-control" name="txtPassword" placeholder="Password" onkeypress="capsLock(event);" required>
            </div>
            <a style="cursor:pointer" onmousedown="$(this).parent().find('input[name=txtPassword]').attr('type','text')" onmouseup="$(this).parent().find('input[name=txtPassword]').attr('type','password')"><span style="z-index:5;position:absolute;top:0;right:0;display:block;width:34px;height:34px;line-height:34px;text-align:center;"><i class="fa fa-eye"></i></span></a>
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
                <label>First Name<sup>*</sup>&emsp;<small>Only alphabets are allowed.</small></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user-o"></span></span>
                  <input type="text" name="txtFirstName" id="txtFirstName" class="form-control" maxlength="50" pattern="[a-zA-Z][a-zA-Z ]+" placeholder="John" required>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Last Name<sup>*</sup>&emsp;<small>Only alphabets are allowed.</small></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user-o"></span></span>
                  <input type="text" name="txtLastName" id="txtLastName" class="form-control" maxlength="50" pattern="[a-zA-Z][a-zA-Z ]+" placeholder="Smith" required>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Birth Date<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                  <input type="text" name="txtBirthDate" id="txtBirthDate" class="form-control birthDate" placeholder="mm/dd/yyyy" onkeypress="return disableKey(event,'letter') && disableKey(event,'number');" autocomplete="off" required>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Contact Number<sup>*</sup>&emsp;<small>Only numbers are allowed.</small></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-mobile fa-lg"></span></span>
                  <input type="text" name="txtContactNumber" id="txtContactNumber" class="form-control" minlength="5" maxlength="20" pattern="[0-9]*$" onkeypress="return disableKey(event,'letter');" required>
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
                  <input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="example@domain.com" maxlength="100" data-error="<?php echo REGISTER_EMAIL_ERROR; ?>" data-remote="<?php echo $root; ?>account?mode=checkEmail" required>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Password<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-key"></span></span>
                  <input type="password" name="txtPassword" id="txtPassword" class="form-control" minlength="8" maxlength="50" pattern="[\s\S]*\S[\s\S]*" required>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Verify Password<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-key"></span></span>
                  <input type="password" name="txtRetypePassword" id="txtRetypePassword" class="form-control" minlength="8" maxlength="50" pattern="[\s\S]*\S[\s\S]*" data-match="#txtPassword" data-match-error="Whoops, these don't match" required>
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
          <button id="btnRegister" type="submit" class="btn btn-primary"<?php echo !VERIFY_REGISTER ? '' : ' disabled'; ?>>Register</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
require_once '../footer.php';
?>