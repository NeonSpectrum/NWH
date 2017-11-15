<li class="dropdown login-dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in"></span><b> Login</b> <span class="caret"></span></a>
  <ul id="login-dp" class="dropdown-menu" style="margin-top:-1px;margin-right:-1px;">
    <li>
      <div class="row">
        <div class="col-md-12">
          <form class="form" method="post" id="frmLogin">
            <div id="lblDisplayErrorLogin" class="lblDisplayError">
              <!-- error will be shown here ! -->
            </div>
            <div class="form-group">
              <label class="sr-only">Email address</label>
              <input id="txtLoginEmail" type="email" class="form-control" name="txtEmail" placeholder="Email address" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label class="sr-only">Password</label>
              <input id="txtLoginPassword" type="password" class="form-control" name="txtPassword" placeholder="Password" onkeypress="capsLock(event);" required>
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
            <div class="help-block text-right"><a style="cursor:pointer" data-toggle="modal" data-target="#modalForgot">Forgot the password ?</a></div>
          </form>
        </div>
      </div>
    </li>
  </ul>
</li>