<?php
  // IF NOT ADMIN SHOW FOOTER AND CONTACT BOX
  if (!strpos($_SERVER['PHP_SELF'],"admin")) 
  {
    // IF CURRENT DIRECTORY IS CONTACT US REMOVE CONTACT BOX
    if ($currentDirectory != 'contactus') {
?>
<div class="contactbox contactbox--tray contactbox--empty">
  <div class="contactbox__title">
      <h5>Contact Us</h5>
      <button class="contactbox__title__tray">
          <span></span>
      </button>
  </div>
  <form class="contactbox__credentials" id="frmContact">
      <div class="form-group">
          <label>Name:</label>
          <input type="text" class="form-control" id="txtName" name="txtName" placeholder="Optional">
      </div>
      <div class="form-group">
          <label>Email:</label>
          <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Valid Email Address" required>
      </div>
      <div class="form-group">
          <label>Message:</label>
          <textarea class="form-control" style="resize:none" id="txtMessage" name="txtMessage" rows="3" placeholder="Write your message..."></textarea>
      </div>
      <button id="btnSubmit" type="submit" class="btn btn-primary btn-block">Send Message</button>
  </form>
</div>
<?php
    }
?>
<div class="footer">
  <div class="center-block" style="width:80%;padding-left:5%;font-size:15px">
  <div class="row" style="padding:20px 0px 80px 0px">
    <div class="col-md-4 footer-content">
      <span class="glyphicon glyphicon-map-marker"></span> ADDRESS<br/>
      <hr style="border-color:#333;margin-top:3px;width:80%;" align="left"/>
      <a href="<?php echo strpos($_SERVER['PHP_SELF'],"contactus") ? '#googleMap' : '/contactus/#googleMap';?>" style="color:#333">No. 21 Quezon Ave. Poblacion, <br/>Alaminos City Pangasinan</a>
    </div>
    <div class="col-md-4 footer-content">
      <span class="	glyphicon glyphicon-search"></span> FOLLOW US<br/>
      <hr style="border-color:#333;margin-top:3px;width:80%;" align="left"/>
      <div class="social-icon">
        <a href="https://www.facebook.com/Northwoodhotel/"><i class="fa fa-3x fa-facebook-square"></i></a>
        <a href="https://www.twitter.com/Northwoodhotel/"><i class="fa fa-3x fa-twitter-square"></i></a>
      </div>
    </div>
    <div class="col-md-4 footer-content">
      <span class="	glyphicon glyphicon-envelope"></span> CONTACT US<br/>
      <hr style="border-color:#333;margin-top:3px;width:80%;" align="left"/>
      (075) 636-0910 / (075) 205-0647<br/>
      0929-789-0088 / 0995-408-6292
    </div>
  </div>
  </div>
</div>
<div class="footer-copyright">
  &copy; 2017 Northwood Hotel. All Rights Reserved
</div>

<!-- REQUIRED JS -->
<?php
  }
  foreach (glob(__DIR__."/assets/js/required/*.js") as $js) {
    $file = str_replace(__DIR__."/", "", $js);
    echo "<script src='{$root}$file?v=" . filemtime($js) . "'></script>\n";
  }
?>

<!-- JSON STRING VARIABLES -->
<?php
  echo "<script>var ";
  $first = true;
  foreach ($json as $string) {
    if (isset($first)) {
      echo "{$string['name']}=\"{$string['value']}\"";
      unset($first);
    }
    echo ",{$string['name']}=\"{$string['value']}\"";
  }
  echo ";const root=\"$root\";";
  echo trim(preg_replace('/\s\s+/', ' ', "function alertNotif(type, message, reload, timeout) {
    $.notify({
      icon:'glyphicon glyphicon-exclamation-sign',
      message: '<div style=\'text-align:center;margin-top:-20px\'>' + message + '</div>'
    }, {
      type: type == 'error' ? 'danger' : type,
      placement: {
        from: 'top',
        align: 'center'
      },
      newest_on_top: true,
      mouse_over: true,
      delay: message.length > 100 ? 0 : 3000
    });
    setTimeout(function () {
      if (reload)
        location.reload();
      else
        return
    }, timeout != null ? timeout : 2000);
  }"));
  echo "</script>\n";
?>

<!-- CUSTOM JS -->
<?php
  if (strpos($_SERVER['PHP_SELF'],"admin")) {
    echo "<script src='{$root}assets/js/admin.js?v=".filemtime(__DIR__."/assets/js/admin.js")."'></script>\n";
  } else {
    echo "<script src='{$root}assets/js/main.js?v=".filemtime(__DIR__."/assets/js/main.js")."'></script>\n";
  }

  if (file_exists(__DIR__."/assets/js/$currentDirectory.js") && $currentDirectory != 'admin') {
    echo "<script src='{$root}assets/js/$currentDirectory.js?v=".filemtime(__DIR__."/assets/js/$currentDirectory.js")."'></script>\n";
  }
  if ((isset($_SESSION['accountType']) && $_SESSION['accountType']!="Owner") || isset($_SESSION) || $_SERVER['SERVER_NAME'] != "localhost") {
    echo "<script src='{$root}assets/js/verifyLoginSession.js?v=" . filemtime(__DIR__."/assets/js/verifyLoginSession.js") . "'></script>\n";
  }
?>
<script src='https://www.google.com/recaptcha/api.js'></script>

</body>
</html>