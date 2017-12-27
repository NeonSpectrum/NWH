<?php
require_once '../header.php';
require_once '../files/navbar.php';

if (!$system->isLogged()) {
  echo "<script>alert('Login First!');location.href='../';</script>";
}

$checkDate = isset($_GET['txtCheckDate']) ? $_GET['txtCheckDate'] : '';
$adults    = isset($_GET['txtAdults']) ? $_GET['txtAdults'] : '1';
$children  = isset($_GET['txtChildren']) ? $_GET['txtChildren'] : '0';
?>
<div class="container-fluid" style="margin-bottom:20px">
  <div class="col-md-9">
    <form id="frmBookNow">
      <div id="smartwizard">
        <ul>
          <li style="width:25%"><a href="#step-1">Step 1<br /><small>Check In & Check Out Date</small></a></li>
          <li style="width:25%"><a href="#step-2">Step 2<br /><small>Select Rooms</small></a></li>
          <li style="width:25%"><a href="#step-3">Step 3<br /><small>Payment</small></a></li>
          <li style="width:25%"><a href="#step-4">Step 4<br /><small>Finish</small></a></li>
        </ul>
        <div style="min-height: 200px">
          <div id="loadingMode"></div>
          <div id="step-1" style="padding:20px">
            <div id="form-step-0" >
              <div class="form-group">
                <label>Check Date:</label>
                <input id="txtCheckDate" type="text" class="form-control checkDate" name="txtCheckDate" value="<?php echo $checkDate; ?>" readonly required>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label>Adult(s):</label>
                    <input id="txtAdults" type="number" class="form-control" name="txtAdults" value="<?php echo $adults; ?>" min="1" max="<?php echo MAX_ADULTS; ?>" required>
                  </div>
                  <div class="col-md-6">
                    <label>Children:</label>
                    <input id="txtChildren" type="number" class="form-control" name="txtChildren" value="<?php echo $children; ?>" min="0" max="<?php echo MAX_CHILDREN; ?>" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="step-2">
            <div id="txtRooms">
            </div>
          </div>
          <div id="step-3">
            <h3> Step 3 - Payment</h3>
            TOTAL AMOUNT OF: ₱&nbsp;<span id="txtRoomPrice"></span>
            <br/><br/>
            <div class="paymentWrap">
              <div class="btn-group paymentBtnGroup btn-group-justified" data-toggle="buttons">
                <label class="btn paymentMethod active">
                  <div class="method cash"></div>
                    <input type="radio" name="txtPaymentMethod" value="Cash" checked>
                </label>
                <label class="btn paymentMethod">
                  <div class="method paypal"></div>
                    <input type="radio" name="txtPaymentMethod" value="PayPal">
                </label>
              </div>
            </div>
          </div>
          <div id="step-4">
            <h3>Your booking ID is <span id="txtBookingID"></span>
            <h3>Your Room ID are:<br/> <span id="txtRoomID"></span>
            <br/>
            <div class="text-right">
              <a id="btnPrint" class="btn btn-primary btn-lg" style="margin-left:20px" type="button">Print</a>
              <a class="btn btn-default btn-lg" href="<?php echo $root; ?>" type="button">Go back to home</a>
            </div>
          </div>
        </div>
      </div>
      <div class="btn-group navbar-btn pull-right" role="group">
        <button class="btn btn-default" id="reset-btn" style="margin-right:10px" type="button">Reset</button>
        <button class="btn btn-primary" id="next-btn" type="button">Next</button>
      </div>
    </form>
  </div>
  <div class="col-md-3">
    <div style="border:1px solid #ccc">
      <div style="background-color:rgb(142, 196, 231);padding:20px;text-align:center;border-bottom:1px solid #ccc;font-size:16pt">Booking Summary</div>
      <div style="padding:5px" id="bookingSummary">
      </div>
    </div>
  </div>
</div>
<div id="modalRules" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Rules and Regulation</h4>
      </div>
      <div class="modal-body" style="padding:30px">
        <li>To guarantee your reservation a down payment of 50% of the total package amount must be made as soon as the booking is confirmed (within 48 hours of guest confirmation) and full payment must be paid during check-in. Failure to deposit down payment will result in forfeiture of reservation. Failure to make full payment will nullify the booking and consequently bestows on Northwood Hotel the right to disallow the guest to use our facilities.</li><br/>
        <li>Any Valid or Government issues Photo ID is required to check in at the hotel.</li><br/>
        <li>All credit card payments incur a surcharge of 5% additionally to the amount charged.</li><br/>
        <li>The rooms are all strictly non-smoking.</li>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php require_once '../footer.php';?>