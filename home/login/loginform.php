<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in"></span><b> Login</b> <span class="caret"></span></a>
  <ul id="login-dp" class="dropdown-menu">
    <li>
      <div class="row">
        <div class="col-md-12">
          <form class="form" role="form" method="post" id="login-nav">
            <div class="form-group">
              <label class="sr-only">Email address</label>
              <input type="email" class="form-control" name="email" placeholder="Email address" required>
            </div>
            <div class="form-group">
              <label class="sr-only">Password</label>
              <input type="password" class="form-control" name="password" placeholder="Password" required>
              <div class="help-block text-right"><a href="">Forgot the password ?</a></div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block" onclick="formSubmit();">Sign in</button>
              <button class="btn btn-default btn-block" type="button" data-toggle="modal" data-target="#registrationModal">Register</button>
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox"> Keep me logged-in
              </label>
            </div>
          </form>
        </div>
      </div>
    </li>
  </ul>
</li>