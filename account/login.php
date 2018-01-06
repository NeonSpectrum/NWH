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
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
require_once "../footer.php";
?>