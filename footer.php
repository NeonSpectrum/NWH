<?php
// IF NOT ADMIN SHOW FOOTER
if (!strpos(strtolower($_SERVER['PHP_SELF']), 'admin') && !strpos(strtolower($_SERVER['PHP_SELF']), 'account/login')) {
  ?>
<div class="footer">
  <div class="center-block" style="width:80%;padding-left:5%;font-size:15px">
  <div class="row" style="padding:20px 0px 80px 0px">
    <div class="col-md-4 footer-content">
      <span class="glyphicon glyphicon-map-marker"></span> LOCATION<br/>
      <hr style="border-color:#333;margin-top:3px;width:80%;" align="left"/>
      <a class="anchor-animate" href="<?php echo strpos(strtolower($_SERVER['PHP_SELF']), 'contactus') ? '#googleMap' : "{$root}contactus/#googleMap"; ?>" style="color:#333">No. 21 Quezon Ave. Poblacion, <br/>Alaminos City Pangasinan</a>
    </div>
    <div class="col-md-4 footer-content">
      <span class="glyphicon glyphicon-search"></span> FOLLOW US<br/>
      <hr style="border-color:#333;margin-top:3px;width:80%;" align="left"/>
      <div class="social-icon">
        <a href="https://www.facebook.com/Northwoodhotel/"><i class="fa fa-3x fa-facebook-square"></i></a>
      </div>
    </div>
    <div class="col-md-4 footer-content">
      <span class="glyphicon glyphicon-envelope"></span> CONTACT US<br/>
      <hr style="border-color:#333;margin-top:3px;width:80%;" align="left"/>
      <span class="glyphicon glyphicon-phone-alt"></span> (075) 636-0910<br/>
      <span class="glyphicon glyphicon-phone"></span> 0929-789-0088 / 0956-226-5236
    </div>
  </div>
  </div>
</div>
<div class="footer-copyright">
  &copy; 2017-<?php echo date('Y'); ?> Northwood Hotel. All Rights Reserved
</div>

<!-- REQUIRED JS -->
<?php
}
foreach (glob(__DIR__ . '/assets/js/required/*.js') as $js) {
  $file = str_replace(__DIR__ . '/', '', $js);
  echo "<script src='{$root}$file?v=" . filemtime($js) . "'></script>\n";
}
if (!strpos(strtolower($_SERVER['PHP_SELF']), 'admin') && !OFFLINE_MODE) {
  if (CHAT) {
    echo "<script async defer data-cfasync='false' src='https://mylivechat.com/chatinline.aspx?hccid=13576530'></script>\n";
  }
  echo "<script src='//www.google.com/recaptcha/api.js'></script>\n";
}
?>

<!-- CUSTOM JS -->
<?php
echo "<script src='${root}assets/js/core.php?v=" . filemtime(__DIR__ . '/assets/js/core.php') . "'></script>\n";
if (strpos(strtolower($_SERVER['PHP_SELF']), 'admin')) {
  echo "<script src='{$root}assets/js/admin.js?v=" . filemtime(__DIR__ . '/assets/js/admin.js') . "'></script>\n";
} else {
  echo "<script src='{$root}assets/js/main.js?v=" . filemtime(__DIR__ . '/assets/js/main.js') . "'></script>\n";
}
if (file_exists(__DIR__ . "/assets/js/$currentDirectory.js")) {
  echo "<script src='{$root}assets/js/$currentDirectory.js?v=" . filemtime(__DIR__ . "/assets/js/$currentDirectory.js") . "'></script>\n";
}
if ($account->isLogged() && !$account->checkUserLevel(1) && $_SERVER['SERVER_NAME'] == 'localhost') {
  echo "<script src='{$root}assets/js/verifyLoginSession.js?v=" . filemtime(__DIR__ . '/assets/js/verifyLoginSession.js') . "'></script>\n";
}
?>

</body>
</html>
