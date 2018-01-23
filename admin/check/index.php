<?php
require_once '../../header.php';
require_once '../../files/sidebar.php';
?>
<main class="l-main">
  <div id="loadingMode" style="display:block"></div>
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">
      Check
      <span class="pull-right">
        <a style="cursor:pointer" data-toggle="modal" data-target="#modalAddBooking" data-tooltip="tooltip" data-placement="bottom" title="Add Walk In"><span class="fa fa-plus"></span></a>
      </span>
    </h1>
    <div class="well">
      <div class="table-responsive">
        <table id="tblBook" class="table table-striped table-bordered table-hover">
          <thead>
            <th>Booking ID</th>
            <th>Email Address</th>
            <th>Room ID(s)</th>
            <th>Adults</th>
            <th>Children</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Extra Charges</th>
            <th>Discount</th>
            <th>Total Amount</th>
            <th>Action</th>
          </thead>
          <tbody>
<?php
$view->check();
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
<div id="modalAddBooking" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Booking ID: <?php echo $system->formatBookingID($system->getNextBookingID()); ?></h4>
      </div>
      <div class="modal-body">
        <form id="frmAddBooking" class="form-horizontal">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label">Email Address: </label>
                <div class="col-sm-8">
                  <select name="txtEmail" class="form-control" id="txtEmail">
<?php
$emails = $system->getAllEmailAddress();
foreach ($emails as $key => $value) {
  ?>
                  <option value='<?php echo $value; ?>'><?php echo $value; ?></option>
<?php
}
?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Check Date: </label>
                <div class="col-sm-8">
                  <div class="input-group date">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    <input name="txtCheckDate" type="text" class="form-control checkDate" id="txtCheckDate" readonly required/>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Adults: </label>
                <div class="col-sm-4">
                  <input name="txtAdults" type="number" class="form-control" id="txtAdults" placeholder="Adults" onkeypress="return disableKey(event,'letter');" value="1" min="1" max="<?php echo MAX_ADULTS; ?>" required/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Children: </label>
                <div class="col-sm-4">
                  <input name="txtChildren" type="number" class="form-control" id="txtChildren" placeholder="Children" onkeypress="return disableKey(event,'letter');" value="0" min="0" max="<?php echo MAX_CHILDREN; ?>" required/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Payment Method: </label>
                <div class="col-sm-4">
                  <select name="txtPaymentMethod" class="form-control" id="txtPaymentMethod">
                    <option value="Cash">Cash</option>
                    <option value="Bank">Bank</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-5 control-label lblRoomType" id='Standard_Single'>Standard Single: </label>
                <div class="col-sm-4">
                  <select class="form-control cmbQuantity">
<?php
$count = count($room->generateRoomID("Standard_Single", null, $date, date("m/d/Y", strtotime($date) + 86500)));
for ($i = 0; $i <= $count; $i++) {
  echo "<option value='$i'>$i</option>";
}
?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-5 control-label lblRoomType" id='Standard_Double'>Standard Double: </label>
                <div class="col-sm-4">
                  <select class="form-control cmbQuantity">
<?php
$count = count($room->generateRoomID("Standard_Double", null, $date, date("m/d/Y", strtotime($date) + 86500)));
for ($i = 0; $i <= $count; $i++) {
  echo "<option value='$i'>$i</option>";
}
?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-5 control-label lblRoomType" id='Family_Room'>Family Room: </label>
                <div class="col-sm-4">
                  <select class="form-control cmbQuantity">
<?php
$count = count($room->generateRoomID("Family_Room", null, $date, date("m/d/Y", strtotime($date) + 86500)));
for ($i = 0; $i <= $count; $i++) {
  echo "<option value='$i'>$i</option>";
}
?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-5 control-label lblRoomType" id='Junior_Suites'>Junior Suites: </label>
                <div class="col-sm-4">
                  <select class="form-control cmbQuantity">
<?php
$count = count($room->generateRoomID("Junior_Suites", null, $date, date("m/d/Y", strtotime($date) + 86500)));
for ($i = 0; $i <= $count; $i++) {
  echo "<option value='$i'>$i</option>";
}
?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-5 control-label lblRoomType" id='Studio_Type'>Studio Type: </label>
                <div class="col-sm-4">
                  <select class="form-control cmbQuantity">
<?php
$count = count($room->generateRoomID("Studio_Type", null, $date, date("m/d/Y", strtotime($date) + 86500)));
for ($i = 0; $i <= $count; $i++) {
  echo "<option value='$i'>$i</option>";
}
?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-5 control-label lblRoomType" id='Barkada_Room'>Barkada Room: </label>
                <div class="col-sm-4">
                  <select class="form-control cmbQuantity">
<?php
$count = count($room->generateRoomID("Barkada_Room", null, $date, date("m/d/Y", strtotime($date) + 86500)));
for ($i = 0; $i <= $count; $i++) {
  echo "<option value='$i'>$i</option>";
}
?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnAdd" type="submit" class="btn btn-info">Add</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="modalAddPayment" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">
        <form id="frmAddPayment" method="post" class="form-horizontal">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" id="txtBookingID" name="txtBookingID">
          <div class="form-group">
            <label class="col-sm-3 control-label">Amount: </label>
            <div class="col-sm-9">
              <input type="number" class="form-control" name="txtPayment" id="txtPayment" required>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnReservation" type="submit" class="btn btn-info">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
   </div>
</div>
<div id="modalAddDiscount" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">
        <form id="frmAddDiscount" method="post" class="form-horizontal">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" id="txtBookingID" name="txtBookingID">
          <div class="form-group">
            <label class="col-sm-3 control-label">Discount: </label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="txtDiscount" id="txtDiscount" pattern="[0-9]+%?" required>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnReservation" type="submit" class="btn btn-info">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="modalReceipt" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <input type="hidden" name="txtBookingID"/>
        <button id="btnPay" type="button" class="btn btn-primary">Pay</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php require_once '../../footer.php';?>