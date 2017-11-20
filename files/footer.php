<?php
  if ($adminPage == true) {
    require $root.'../files/scriptAdmin.php';
  } else {
?>
<div class="footer">
  <div class="center-block" style="width:80%;padding-left:10%;font-size:15px">
    <div class="footer-content">
      <hr style="border-color:white;border-width:3px;width:10%;" align="left"/>
      <a href="<?php echo strpos($_SERVER['PHP_SELF'],"contactus") ? '#googleMap' : '/nwh/contactus/#googleMap';?>" style="color:#333">No. 21 Quezon Ave. Poblacion, <br/>Alaminos City Pangasinan</a>
    </div>
    <div class="footer-content">
      <hr style="border-color:white;border-width:3px;width:10%;" align="left"/>
      Follow Us
      <br/>
      <a href="https://www.facebook.com/Northwoodhotel/"><img src="/nwh/images/fb.png" height="25px" width="25px"/></a>
    </div>
    <div class="footer-content">
      <hr style="border-color:white;border-width:3px;width:10%;" align="left"/>
      &copy; 2017 Northwood Hotel
      <br/><br/>
      (075) 636-0910 / (075) 205-0647<br/>
      0929-789-0088 / 0995-408-6292
    </div>
  </div>
</div>
<?php
    require $root.'../files/scriptMain.php';
  }
?>
  </body>
</html>