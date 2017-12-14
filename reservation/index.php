<?php

session_start();
if (!isset($_SESSION['email'])) {
  echo "<script>alert('Login First!');location.href='../';</script>";
}
require_once '../header.php';
require_once '../files/navbar.php';

$checkInDate  = isset($_GET['txtCheckInDate']) ? $_GET['txtCheckInDate'] : '';
$checkOutDate = isset($_GET['txtCheckOutDate']) ? $_GET['txtCheckOutDate'] : '';
$adults       = isset($_GET['txtAdults']) ? $_GET['txtAdults'] : '1';
$children     = isset($_GET['txtChildren']) ? $_GET['txtChildren'] : '0';
?>
<div class="container-fluid" style="margin-bottom:20px">
  <div class="stepwizard col-md-offset-2">
    <div class="stepwizard-row setup-panel">
      <div class="stepwizard-step">
        <div id="btn-step1" class="btn-stepwizard <?php echo isset($_GET['txtCheckInDate']) ? '' : 'active'; ?>">1</div>
        <p>Step 1</p>
      </div>
      <div class="stepwizard-step">
        <div id="btn-step2" class="btn-stepwizard <?php echo isset($_GET['txtCheckInDate']) ? 'active' : ''; ?>">2</div>
        <p>Step 2</p>
      </div>
      <div class="stepwizard-step">
        <div id="btn-step3" class="btn-stepwizard">3</div>
        <p>Step 3</p>
      </div>
      <div class="stepwizard-step">
        <div id="btn-step4" class="btn-stepwizard">4</div>
        <p>Finish</p>
      </div>
    </div>
  </div>

  <form id="frmBookNow">
    <div class="row setup-content">
      <div class="col-md-8 col-md-offset-2">
        <div class="col-md-12">
          <div id="step1" class="step animated fadeIn" style="<?php echo isset($_GET['txtCheckInDate']) ? 'display:none' : ''; ?>">
            <h3> Step 1 - Check</h3>
            <div class="form-group">
              <label>Check In Date:</label>
              <input id="txtCheckInDate" type="text" class="form-control checkInDate" name="txtCheckInDate" value="<?php echo $checkInDate; ?>" required readonly>
            </div>
            <div class="form-group">
              <label>Check Out Date:</label>
              <input id="txtCheckOutDate" type="text" class="form-control checkOutDate" name="txtCheckOutDate" value="<?php echo $checkOutDate; ?>" required readonly>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label>Adults:</label>
                  <input id="txtAdults" type="number" class="form-control" name="txtAdults" value="<?php echo $adults; ?>" min="1" max="10" required>
                </div>
                <div class="col-md-6">
                  <label>Children:</label>
                  <input id="txtChildren" type="number" class="form-control" name="txtChildren" value="<?php echo $children; ?>" min="0"max="10" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <button class="btn btn-primary btnNext btn-lg pull-right" type="button">Next</button>
            </div>
          </div>
          <div id="step2" class="step animated fadeIn" style="<?php echo isset($_GET['txtCheckInDate']) ? '' : 'display:none'; ?>">
            <h3> Step 2 - Room</h3>
            <div class="row">
              <span id="txtRooms"></span>
            </div>
            <div class="form-group">
              <button class="btn btn-primary btnPrev btn-lg pull-left" type="button">Previous</button>
              <button class="btn btn-primary btnNext btn-lg pull-right" type="button">Next</button>
            </div>
          </div>
          <div id="step3" class="step animated fadeIn" style="display:none">
            <h3> Step 3 - Payment</h3>
            TOTAL AMOUNT OF: ₱&nbsp;<span id="txtRoomPrice"></span>
            <br/><br/><br/><br/><br/><br/><br/><br/>
            <div class="form-group">
              <button class="btn btn-primary btnPrev btn-lg pull-left" type="button">Previous</button>
              <button id="btnSubmit" class="btn btn-primary btn-lg pull-right" type="button">Submit</button>
            </div>
          </div>
          <div id="step4" class="step animated fadeIn" style="display:none">
            <br/><br/>
            <h3>Your booking ID is <span id="txtBookingID"></span>
            <h3>Your Room ID is <span id="txtRoomID"></span>
            <br/><br/><br/><br/>
            <a id="btnPrint" class="btn btn-primary btn-lg pull-right" style="margin-left:20px" type="button">Print</a>
            <a class="btn btn-default btn-lg pull-right" href="<?php echo $root; ?>" type="button">Go back to home</a>
            <br/><br/><br/><br/>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<?php require_once '../footer.php';?>