<?php
require_once '../header.php';
require_once '../files/navbar.php';
?>
<div class="container-fluid">
  <div class="well center-block" style="width:75%;background:rgba(255,255,255,0.7)">
    <h1 style="margin-top:0px;text-align:center;font-weight:bold">CONTACT US</h1>
    <hr style="border-color:black"/>
    <div class="box-content">
      <h2>Northwood Hotel</h2><br/>
      <i><b><font size="2px">21 Quezon Ave. Poblacion, Alaminos City Pangasinan<br/>
      For inquiries call or text .<br/>
      TEL NOS. (075) 636-0910 / (075) 205-0647<br/>
      MOBILE NOS. 09297890088 / 09954086292</font></b></i>
    </div>
    <div class="box-content">
      <form class="form-horizontal center-block text-center" id="frmContact">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>"/>
        <div class="form-group">
          <input style="width:90%" name="txtName" type="text" class="form-control" placeholder="Name" maxlength="101" <?php echo isset($_SESSION['account']) ? "value='{$account->firstName} {$account->lastName}' readonly" : ""; ?> required />
        </div>
        <div class="form-group">
          <input id="txtEmail" style="width:90%" name="txtEmail" type="email" class="form-control" placeholder="Email" maxlength="100" <?php echo isset($_SESSION['account']) ? "value='{$system->decrypt($_SESSION['account'])}' readonly" : ""; ?> required />
        </div>
        <div class="form-group">
          <input id="txtContactNumber" style="width:90%" name="txtContactNumber" type="text" class="form-control" placeholder="Contact Number (Optional)" minlength="5" maxlength="20" <?php echo isset($_SESSION['account']) ? "value='{$account->contactNumber}' readonly" : ""; ?>/>
        </div>
        <div class="form-group">
          <textarea id="txtMessage" style="width:90%;resize:none" name="txtMessage" rows="5" class="form-control" placeholder="Message" maxlength="255" required></textarea>
        </div>
        <div class="form-group">
          <button id="btnSubmit" type="submit" class="btn btn-primary" style="width:90%">Send</button>
        </div>
      </form>
    </div>
    <iframe id="googleMap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3832.3366038685053!2d119.98159901485965!3d16.15158288883011!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3393dccfc08751e7%3A0x7c1d4eb8d67dd9fc!2sNorthwood+Hotel!5e0!3m2!1sen!2sph!4v1508862737842" style="margin-top:10px;width:100%;height:550px" frameborder="0" style="border:0" allowfullscreen></iframe>
  </div>
</div>
<?php require_once '../footer.php';?>