<?php 
  if (!isset($_SESSION['email'])) {
    header("location: ../");
    exit();
  }
  
  require_once '../header.php';
  require_once '../files/navbar.php';
  
  $step = isset($_GET['step']) ? $_GET['step'] : '';
  $checkInDate = isset($_GET['txtCheckInDate']) ? $_GET['txtCheckInDate'] : '';
  $checkOutDate = isset($_GET['txtCheckOutDate']) ? $_GET['txtCheckOutDate'] : '';
  $adults = isset($_GET['txtAdults']) ? $_GET['txtAdults'] : '0';
  $children = isset($_GET['txtChildren']) ? $_GET['txtChildren'] : '0';
  $room = isset($_GET['rdbRoom']) ? $_GET['rdbRoom'] : '';
  $roomID = isset($_GET['txtRoomID']) ? $_GET['txtRoomID'] : '';
  $bookingID = isset($_GET['txtBookingID']) ? $_GET['txtBookingID'] : '';
?>
<div class="container-fluid" style="margin-bottom:20px">
  <div class="stepwizard col-md-offset-3">
    <div class="stepwizard-row setup-panel">
      <div class="stepwizard-step">
        <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
        <p>Step 1</p>
      </div>
      <div class="stepwizard-step">
        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled>2</a>
        <p>Step 2</p>
      </div>
      <div class="stepwizard-step">
        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled>3</a>
        <p>Step 3</p>
      </div>
      <div class="stepwizard-step">
        <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled>4</a>
        <p>Finish</p>
      </div>
    </div>
  </div>
    
  <form id="frmBookNow">
    <div class="row setup-content" id="step-1">
      <div class="col-md-6 col-md-offset-3">
        <div class="col-md-12">
          <input id="stepID" type="hidden" name="step" value="<?php echo $step;?>"/>
          <h3> Step 1 - Check</h3>
          <div class="form-group">
            <label>Check In Date:</label>
            <input id="txtCheckInDate" type="date" class="form-control checkInDate" name="txtCheckInDate" value="<?php echo $checkInDate;?>" onkeypress="return disableKey(event,'number')" required>
          </div>
          <div class="form-group">
            <label>Check Out Date:</label>
            <input id="txtCheckOutDate" type="date" class="form-control checkOutDate" name="txtCheckOutDate" value="<?php echo $checkOutDate;?>" onkeypress="return disableKey(event,'number')" required>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label>Adults:</label>
                <input id="txtAdults" type="number" class="form-control" name="txtAdults" value="<?php echo $adults;?>" max="10" required>
              </div>
              <div class="col-md-6">
                <label>Children:</label>
                <input id="txtChildren" type="number" class="form-control" name="txtChildren" value="<?php echo $children;?>" max="10" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <button id="nextBtn" class="btn btn-primary nextBtn btn-lg pull-right" type="button" onclick="return">Next</button>
          </div>
        </div>
      </div>
    </div>
    <div class="row setup-content" id="step-2">
      <div class="col-md-6 col-md-offset-3">
        <div class="col-md-12">
          <h3> Step 2 - Room</h3>
          <div class="row" style="padding-left:0px">
            <ul class="rooms">
              <?php
                $query = "SELECT * FROM room_type";
                $result = mysqli_query($db, $query);
                $x = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                  if ((int)$row['Capacity'] > $adults) {
                    $checked = $room == $row['RoomType'] ? 'checked' : '';
                    echo "<li class='col-md-6'><input type='checkbox' id='cb".$x."' name='rdbRoom' value='{$row['RoomType']}' $checked/>
                    <label class='room-label' for='cb".$x++."'>";
                    if (mktime(0, 0, 0, 10, 1, date('Y')) < mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y')) && mktime(11, 59, 59, 5, 31, date('Y') + 1) > mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y'))) {
                      $price = $row['PeakRate'];
                    } else if (mktime(0, 0, 0, 7, 1, date('Y')) < mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y')) && mktime(11, 59, 59, 8, 31, date('Y') + 1) > mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y'))) {
                      $price = $row['LeanRate'];
                    } else {
                      $price = $row['DiscountedRate'];
                    }
                    echo "<figure class='imghvr-push-up' style='box-shadow: 1px 1px 1px #888888'>
                            <img src='../gallery/images/rooms/{$row['RoomType']}.jpg'>
                            <figcaption style='background-color:rgb(235,235,235);text-align:center;color:black;padding-top:0px'>
                                <h3 style='color:black'>".str_replace("_"," ",$row['RoomType'])."</h3><br/>
                                <p>₱&nbsp;".number_format($price)."</p>
                            </figcaption>
                          </figure>";
                    echo "</label></li>";
                  }
                }
              ?>
              <input type="hidden" id="txtRoomID" name="txtRoomID" value="<?php echo $roomID;?>"/>
            </ul>
          </div>
          <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
        </div>
      </div>
    </div>
    <div class="row setup-content" id="step-3">
      <div class="col-md-6 col-md-offset-3">
        <div class="col-md-12">
          <h3> Step 3 - Payment</h3>
          TOTAL AMOUNT OF: ₱&nbsp;<?php echo number_format($price)?>
          <br/><br/><br/><br/><br/><br/><br/><br/>
          <button class="btn btn-primary btn-lg pull-right" id="btnBookNow" type="submit">Submit</button>
        </div>
      </div>
    </div>
    <div class="row setup-content" id="step-4">
      <div class="col-md-6 col-md-offset-3">
        <div class="col-md-12">
          <br/><br/>
          <h3>Your booking ID is <?php echo $bookingID?>.</h3>
          <br/><br/><br/><br/>
          <a class="btn btn-primary btn-lg pull-right" href="<?php echo $root;?>files/generateReservationConfirmation.php?BookingID=<?php echo $bookingID;?>" style="margin-left:20px" type="button">Print</a>
          <a class="btn btn-default btn-lg pull-right" href="<?php echo $root;?>" type="button">Go back to home</a>
          <br/><br/><br/><br/>
        </div>
      </div>
    </div>
  </form>
</div>
<?php require_once '../footer.php';?>