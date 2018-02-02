<?php
require_once '../../header.php';
require_once '../../files/sidebar.php';
?>
<main class="l-main">
  <div id="loadingMode" style="display:block"></div>
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">
      Booking
      <span class="pull-right">
        <a style="cursor:pointer" title="Add" href="<?php echo $root; ?>reservation"><span class="fa fa-plus"></span></a>
      </span>
    </h1>
    <div class="well">
      <div class="table-responsive">
        <table id="tblBooking" class="table table-striped table-bordered table-hover">
          <thead>
            <th>Booking ID</th>
            <th>Email Address</th>
            <th>Room ID</th>
            <th>Check In Date</th>
            <th>Check Out Date</th>
            <th>Adults</th>
            <th>Children</th>
            <th>Amount Paid</th>
            <th>Balance</th>
            <th>Total Amount</th>
            <th>Action</th>
          </thead>
          <tbody>
<?php
$view->booking();
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
<div id="modalAddPayment" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">
        <form id="frmAddPayment" method="post" class="form-horizontal">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" id="txtBookingID" name="txtBookingID">
          <div class="form-group">
            <label class="col-sm-3 control-label">Amount: </label>
            <div class="col-sm-9">
              <input type="number" class="form-control" name="txtPayment" id="txtPayment">
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
<div id="modalEditReservation" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Edit Reservation</h4>
      </div>
      <div class="modal-body">
        <form id="frmEditReservation" method="post" class="form-horizontal">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" id="cmbBookingID" name="cmbBookingID">
          <div class="form-group">
            <label class="col-sm-3 control-label">Check Date</label>
            <div class="col-sm-7">
              <div class="input-group date">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input name="txtCheckDate" type="text" class="form-control checkDate" id="txtCheckDate" required readonly/>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Adults</label>
            <div class="col-sm-3">
              <input name="txtAdults" type="number" class="form-control" id="txtAdults" placeholder="Adults" onkeypress="disableKey(event,'letter');" min="1" max="10" value="1" required/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Children</label>
            <div class="col-sm-3">
              <input name="txtChildren" type="number" class="form-control" id="txtChildren" placeholder="Children" onkeypress="return disableKey(event,'letter');" min="0" max="10" value="0" required/>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnUpdate" type="submit" class="btn btn-info">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="modalEditRoom" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">
        <form id="frmEditRoom" method="post" class="form-horizontal">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" id="txtBookingID" name="txtBookingID">
          <input type="hidden" id="txtRoomID" name="txtRoomID">
          <input type="hidden" id="txtType" name="txtType">
          <div class="form-group">
            <label class="col-sm-3 control-label">Room Type</label>
            <div class="col-sm-7">
              <select id="cmbRoomType" name="cmbRoomType" class="form-control">
                <option selected>Standard Single</option>
                <option>Standard Double</option>
                <option>Family Room</option>
                <option>Junior Suites</option>
                <option>Studio Type</option>
                <option>Barkada Room</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Room ID</label>
            <div class="col-sm-4">
              <select name="cmbNewRoomID" class="form-control" id="cmbNewRoomID" required/>

              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnUpdate" type="submit" class="btn btn-info">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php require_once '../../footer.php';?>