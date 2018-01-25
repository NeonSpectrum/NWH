<?php
require_once '../../../header.php';
$system->checkUserLevel(2, true);
require_once '../../../files/sidebar.php';
?>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">Control Panel</h1>
    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>"/>
<?php
if ($system->checkUserLevel(3)) {
  ?>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Send to All</div>
        <div class="panel-body">
          <form id="frmSendToAllAdmin">
            Message: <input type="text" name="txtMessage" class="form-control"><br/>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Trolls</div>
        <div class="panel-body">
          <form id="frmPlayMusic">
            <input type="text" name="url" class="form-control" style="width:100%" placeholder="Insert URL or keywords recorded">
          </form>
          <br/>
          <button class="btn btn-default btn-block" id="btnKickAss">Kick Ass</button>
        </div>
      </div>
    </div>
<?php
}
?>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Generate Report</div>
        <div class="panel-body">
          <form id="frmGenerateReport">
            <input type="text" name="daterange" class="form-control" style="width:100%">
            <br/>
            <input type="submit" class="btn btn-default btn-block" value="Generate">
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Check</div>
        <div class="panel-body">
            <select id="cmbBookingID" class="form-control" style="width:100%;margin-bottom:5px">
<?php
$result = $db->query("SELECT booking.BookingID, EmailAddress, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children, ExtraCharges, Discount FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE CheckIn IS NOT NULL");
while ($row = $result->fetch_assoc()) {
  $dates = $system->getDatesFromRange($row['CheckInDate'], date("Y-m-d", strtotime($row['CheckOutDate']) - 86400));
  if (in_array($date, $dates)) {
    echo "<option value='{$row['BookingID']}'>{$system->formatBookingID($row['BookingID'])}</option>";
  }
}
?>
            </select>
            <button class="btn btn-default btn-block" id="btnRevertCheckIn">Revert Check In</button>
            <button class="btn btn-default btn-block" id="btnRevertCheckOut">Revert Check Out</button>
        </div>
      </div>
    </div>
<?php
if ($system->checkUserLevel(3)) {
  ?>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Website Control</div>
        <div class="panel-body">
          <button class="btn btn-default btn-block" id="btnRemoveBooking">Remove All Booking</button>
          <button class="btn btn-default btn-block" id="btnForceRefresh">Force Refresh</button>
        </div>
      </div>
    </div>
<?php
}
?>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Database Backup (Ctrl or Shift to select)</div>
        <div class="panel-body">
          <select multiple class="form-control" name="cmbTablesToBackup">
<?php
$result = $db->query("SHOW TABLES FROM cp018101_nwh");
while ($row = $result->fetch_assoc()) {
  echo "<option value='{$row['Tables_in_cp018101_nwh']}'>{$row['Tables_in_cp018101_nwh']}</option>";
}
?>
          </select>
          <br/>
          <div class="btn-group btn-group-justified">
            <div class="btn-group">
              <button class="btn btn-default" id="btnBackupSql">Backup As SQL</button>
            </div>
            <div class="btn-group">
              <button class="btn btn-default" id="btnBackupExcel">Backup As Excel</button>
            </div>
          </div>
          <button class="btn btn-default btn-block" id="btnBackupAll">Backup All</button>
        </div>
      </div>
    </div>
  </div>
</main>
<?php require_once '../../../footer.php';?>