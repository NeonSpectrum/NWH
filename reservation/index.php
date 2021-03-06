<?php
require_once '../header.php';
require_once '../files/navbar.php';

$system->redirectLogin();

$checkDate = $_POST['txtCheckDate'] ?? '';
$adults    = $_POST['txtAdults'] ?? '1';
$children  = $_POST['txtChildren'] ?? '0';
?>
<div class="container-fluid" style="margin-bottom:20px">
  <div class="col-md-9">
    <form id="frmBookNow">
      <div id="smartwizard">
        <ul>
          <li style="width:25%"><a style="pointer-events:none" href="#step-1">Step 1<br/><small>Check In & Check Out Date</small></a></li>
          <li style="width:25%"><a style="pointer-events:none" href="#step-2">Step 2<br/><small>Select Rooms</small></a></li>
          <li style="width:25%"><a style="pointer-events:none" href="#step-3">Step 3<br/><small>Payment</small></a></li>
          <li style="width:25%"><a style="pointer-events:none" href="#step-4">Step 4<br/><small>Finish</small></a></li>
        </ul>
        <div style="min-height: 200px">
          <div id="loadingMode"></div>
          <div id="step-1" style="padding:20px" class="<?php echo isset($_POST['txtCheckDate']) ? ' skip' : ''; ?>">
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
            <div id="txtSuggestedRooms">

            </div>
            <div id="txtOtherRooms" style="display:none">

            </div>
            <button id="btnShowMore" style="margin-bottom:10px" type="button" class="btn btn-default btn-block">Show Other Rooms</button>
          </div>
          <div id="step-3">
            <h3> Step 3 - Payment</h3>
            TOTAL AMOUNT OF: <span style="font-size:20px;font-weight:bold">₱</span>&nbsp;<span id="txtRoomPrice" style="font-size:20px;font-weight:bold"></span>
            <br/><br/>
            <div class="paymentWrap">
              <div class="btn-group paymentBtnGroup btn-group-justified" data-toggle="buttons">
                <label class="btn paymentMethod active" data-tooltip="tooltip" data-placement="bottom" title="Cash">
                  <div class="method cash"></div>
                  <input type="radio" name="txtPaymentMethod" value="Cash" checked>
                </label>
                <label class="btn paymentMethod" data-tooltip="tooltip" data-placement="bottom" title="Bank">
                  <div class="method bank"></div>
                  <input type="radio" name="txtPaymentMethod" value="Bank">
                </label>
<?php
if (ALLOW_PAYPAL == true) {
  ?>
                <label class="btn paymentMethod" data-tooltip="tooltip" data-placement="bottom" title="Paypal">
                  <div class="method paypal"></div>
                  <input type="radio" name="txtPaymentMethod" value="PayPal">
                </label>
<?php
}
?>
              </div>
              <br/>
              <div class="checkbox">
                <label style="font-size:20px">
                  <input type="checkbox" name="cbxTermsAndConditions" style="width:15px;height:15px">
                  I've read the <a style="text-decoration:underline;text-decoration-style:dotted;cursor:pointer" data-toggle="modal" data-target="#modalTerms">Terms and Conditions</a>
                </label>
              </div>
            </div>
          </div>
          <div id="step-4">
            <div class="table-response" id="tblResult"></div>
            <br/>
            <div class="text-right" style="margin-bottom:10px">
              <a id="btnPrint" class="btn btn-primary" style="margin-left:20px" type="button">Print</a>
              <a class="btn btn-default" href="<?php echo $root; ?>" type="button">Go back to home</a>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-btn col-md-12 btn-group" style="height:50px;display:block" role="group">
        <button class="btn btn-primary pull-right" style="margin-left:5px;width:80px" id="next-btn" type="button">Next</button>
        <button class="btn btn-primary pull-right" style="margin-left:5px;width:80px;display:none" id="prev-btn" type="button">Previous</button>
        <button class="btn btn-default pull-right" style="width:80px" id="reset-btn" type="button">Reset</button>
      </div>
    </form>
  </div>
  <div class="col-md-3">
    <div style="border:1px solid #ccc">
      <div style="background-color:rgb(142, 196, 231);padding:20px;text-align:center;border-bottom:1px solid #ccc;font-size:16pt">Booking Summary</div>
      <div style="padding:5px;overflow-y:auto;max-height:300px" id="bookingSummary">
        <div id="info"></div>
        <div id="roomList"></div>
        <div id="paymentMethod"></div>
      </div>
    </div>
  </div>
</div>
<div id="modalTerms" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Terms and Conditions</h4>
      </div>
      <div class="modal-body" style="padding:30px;padding-right:50px">
        <ol type="1">
          <li><p align="justify">To Check-in, each person is asked to present a valid identity document (ID card or passport) and fill in the registration form/card.</p></li>
          <li><p align="justify">Visitors are not allowed in rooms. Please use the lobby for socializing and meetings.</p></li>
          <li><p align="justify">Check-out time is 12:00nn; Check-in time is 2:00pm. Extension of stay will be charge at Php 200.00 per hour with the maximum of three (3) hours stay only, exceeding the maximum time will be considered as one night stay and will be charged automatically.</p></li>
          <li><p align="justify">Management is not liable for loss of personal property; Guests are advised to secure their personal belongings and valuables. Safety Deposit is available at the Front Desk for your valuables.</p></li>
          <li><p align="justify">If you like your rooms to be made up please inform the Front Desk prior to departing for the day. Make-up time is from 9:00am 4:00 pm only.</p></li>
          <li><p align="justify">Being an environmentally conscious hotel, change of bedding linens and towel is done on the second day of stay. Extra pillow, towels, soap and shampoo will incur a corresponding charge. Room inventory (pillows, linens, towels, etc.) are intended for you to use while staying in the Hotel and are not to be taken out.</p></li>
          <li><p align="justify">Please turn over key at Front Desk before departing the hotel. Lost key will be charged at Php 500.00 per piece.</p></li>
          <li><p align="justify">Hotel guests are asked to respect the smoking and non-smoking areas. All rooms are non-smoking. A cleaning fee minimum of Php 1,000.00 will be charged to guests who do not abide by the no smoking policy.</p></li>
          <li><p align="justify">For security reasons it is not permitted to use own appliances. The exceptions are: cellphones, radio and personal computer. Guest is the responsible and liable for any damages caused by their use.</p></li>
          <li><p align="justify">Guests are asked not to move any of the room's equipment and not do interfere to the power line. Please take care of the Hotel inventory. All intentional damages occurring during your stay shall be charged on your account.</p></li>
          <li><p align="justify">No guarantee for electricity during blackout. However we will provide you an emergency light available at the Front Desk</p></li>
          <li><p align="justify">It is not allowed to leave children in the room unattended. Parents are responsible for the safety of their children in all areas of the hotel. Do not bother other guests, such as singing loudly, or any other noisy actions, etc.</p></li>
          <li><p align="justify">When leaving the room, guest is asked to close all water taps, turn off the lights, air-con, TV, and other electrical appliances and please make sure all faucets I showers are properly turned-off when not in use. When unattended, please close room windows and keep doors locked.</p></li>
          <li><p align="justify">Before or at designated Check-out Time, please allow our Housekeeping staff to check your room. Missing items from the room will be charged to guest account. Please allow 10 minutes check out time to facilitate.</p></li>
          <li><p align="justify">Hotel management or reception staff will welcome all your suggestions for improving any of provided services. </p></li>
        </ol>
      </div>
      <div class="modal-footer">
        <p style="text-align:center;font-size:18px">Thank you for your cooperation and have a nice and pleasant stay with us.<br/>We hope to see you all again in the future.</p>
      </div>
    </div>
  </div>
</div>
<?php require_once '../footer.php';?>
