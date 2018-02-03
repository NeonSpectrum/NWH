<?php
require_once '../../header.php';
require_once '../../files/sidebar.php';
?>
<main class="l-main">
  <div id="loadingMode" style="display:block"></div>
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">Check</h1>
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
<div id="modalAddExpenses" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <form id="frmAddExpenses" method="post" class="form-horizontal">
        <div class="modal-body">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" id="txtBookingID" name="txtBookingID">
          <div class="form-group">
            <label class="col-sm-3 control-label">Expenses Type:</label>
            <div class="col-sm-9">
              <select id="cmbExpensesType" name="cmbExpensesType" class="form-control">
<?php
$result  = $db->query("SELECT * FROM expenses");
$payment = $result->fetch_assoc()['Amount'];
$result->data_seek(0);
while ($row = $result->fetch_assoc()) {
  if ($row['Name'] != "Others") {
    echo "<option value='{$row['Amount']}'>{$row['Name']}</option>";
  }
}
?>
                <option>Others</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Quantity: </label>
            <div class="col-sm-9">
              <input type="number" class="form-control" name="txtQuantity" id="txtQuantity" value="1" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Amount: </label>
            <div class="col-sm-9">
              <input type="number" class="form-control" name="txtPayment" id="txtPayment" min="1" value="<?php echo $payment; ?>" readonly required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="btnAdd" type="submit" class="btn btn-primary">Add</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
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
      <form id="frmAddDiscount" method="post" class="form-horizontal">
        <div class="modal-body">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" id="txtBookingID" name="txtBookingID">
          <div class="form-group">
            <label class="col-sm-3 control-label">Expenses Type:</label>
            <div class="col-sm-9">
              <select id="cmbDiscountType" name="cmbDiscountType" class="form-control">
<?php
$result   = $db->query("SELECT * FROM discount");
$discount = $result->fetch_assoc()['Amount'];
$result->data_seek(0);
while ($row = $result->fetch_assoc()) {
  if ($row['Name'] != "Others") {
    echo "<option value='{$row['Amount']}'>{$row['Name']}</option>";
  }
}
?>
                <option>Others</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Discount: </label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="txtDiscount" id="txtDiscount" min="1" value="<?php echo $discount; ?>" pattern="[0-9]+%?" readonly required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="btnAdd" type="submit" class="btn btn-primary">Add</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="modalReceipt" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div id="loadingMode" style="background-size: 20%;background-position: 50% 40%;"></div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer" style="clear:both">
        <input type="hidden" name="txtBookingID"/>
        <button id="btnPay" type="button" class="btn btn-primary">Pay</button>
        <button id="btnPrint" type="button" class="btn btn-primary">Print</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php require_once '../../footer.php';?>