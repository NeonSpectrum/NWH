<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in"></span><b> Login</b> <span class="caret"></span></a>
  <ul id="login-dp" class="dropdown-menu">
    <li>
      <div class="row">
        <div class="col-md-12">
          <form class="form" method="post" id="loginform">
            <div id="errorLogin">
              <!-- error will be shown here ! -->
            </div>
            <div class="form-group">
              <label class="sr-only">Email address</label>
              <input type="email" class="form-control" name="email" placeholder="Email address" required>
            </div>
            <div class="form-group">
              <label class="sr-only">Password</label>
              <input id="pass" type="password" class="form-control" name="password" placeholder="Password" onkeypress="capsLock(event);" required>
              <div id="caps" style="display:none;margin-top:4px;margin-left:2px;">Caps Lock is on.</div> 
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="remembercheckbox" checked> Keep me logged-in
                </label>
              </div>
            </div>
            <div class="form-group">
              <button id="login" type="submit" class="btn btn-primary btn-block" onclick="submitLoginForm();return false;">Sign in</button>
              <button class="btn btn-default btn-block" type="button" data-toggle="modal" data-target="#registrationModal">Register</button>
            </div>
            <div class="help-block text-right"><a style="cursor:pointer" data-toggle="modal" data-target="#changeModal">Change password ?</a></div>
            <div class="help-block text-right"><a style="cursor:pointer" data-toggle="modal" data-target="#forgotModal">Forgot the password ?</a></div>
          </form>
        </div>
      </div>
    </li>
  </ul>
</li>