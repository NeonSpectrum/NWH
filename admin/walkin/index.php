<?php
require_once '../../header.php';
$system->checkUserLevel(1, true);
?>
<?php require_once '../../files/sidebar.php';?>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">
      Walk In
      <span class="pull-right">
        <a style="cursor:pointer" title="Add" data-toggle="modal" data-target="#modalAddWalkIn"><span class="fa fa-plus"></span></a>
      </span>
    </h1>
    <div class="well">
      <div class="table-responsive">
        <table id="tblReservation" class="table table-striped table-bordered table-hover">
          <thead>
            <th>Walk In ID</th>
            <th>Email Address</th>
            <th>Room ID</th>
            <th style="display:none">Room Type</th>
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
$view->walkin();
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
<div id="modalAddWalkIn" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Walk In ID: <?php echo $system->getNextWalkInID(); ?></h4>
      </div>
      <div class="modal-body">
        <form id="frmAddWalkIn" class="form-horizontal">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" id="txtWalkInID" name="txtWalkInID" value="<?php echo $system->getNextWalkInID(); ?>">
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
            </div>
            <div class="col-md-6">
              <div class="col-md-12">
                <p><label class="control-label">Rooms: </label></p>
              </div>
              <div class="form-group">
                <div class="col-sm-8">
                  <select name="cmbRoomType" class="form-control cmbRoomType">
                    <option value="Standard_Single" selected>Standard Single</option>
                    <option value="Standard_Double">Standard Double</option>
                    <option value="Family_Room">Family Room</option>
                    <option value="Junior_Suites">Junior Suites</option>
                    <option value="Studio_Type">Studio Type</option>
                    <option value="Barkada_Room">Barkada Room</option>
                  </select>
                </div>
                <div class="col-sm-3">
                  <input type="number" id="txtQuantity" name="txtQuantity" class="form-control">
                </div>
              </div>
              <div class="col-sm-12" style="margin:10px 0">
                <button type="button" id="btnAddRoomSlot" class="btn btn-block" style="background-color:transparent;border:1px solid black;border-style:dashed;box-shadow:none">Add</button>
              </div>
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
<div id="modalAddPayment" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">
        <form id="frmAddPayment" class="form-horizontal">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" id="txtWalkInID" name="txtWalkInID">
          <div class="form-group">
            <label class="col-sm-3 control-label">Amount: </label>
            <div class="col-sm-9">
              <input type="number" class="form-control" name="txtPayment" id="txtPayment">
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
<div id="modalEditReservation" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Edit Reservation</h4>
      </div>
      <div class="modal-body">
        <form id="frmEditReservation" class="form-horizontal">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" id="cmbWalkInID" name="cmbWalkInID">
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
              <select name="cmbRoomID" class="form-control" id="cmbRoomID" required/>

              </select>
            </div>
          </div>
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
            <button id="btnReservation" type="submit" class="btn btn-info">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
   </div>
</div>
<?php require_once '../../footer.php';?>