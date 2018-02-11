<?php
require_once '../../../header.php';
$account->checkUserLevel(2, true);
require_once '../../../files/sidebar.php';
?>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">Control Panel</h1>
    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
<?php
if ($account->checkUserLevel(3)) {
  ?>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Send to All</div>
        <div class="panel-body">
          <form id="frmSendToAllAdmin">
            Message: <input type="text" name="txtMessage" class="form-control">
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
          <button class="btn btn-default btn-block" style="margin-top:5px" id="btnKickAss">Kick Ass</button>
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
            <input type="text" name="daterange" class="form-control" style="width:100%" readonly>
            <input type="submit" class="btn btn-default btn-block" style="margin-top:5px" value="Generate">
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
$result = $db->query("SELECT * FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE CheckIn IS NOT NULL");
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
if ($account->checkUserLevel(3)) {
  ?>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Website Control</div>
        <div class="panel-body">
          <button class="btn btn-default btn-block" id="btnRemoveBooking">Remove All Booking</button>
          <button class="btn btn-default btn-block" id="btnEditConfig" data-toggle="modal" data-target="#modalEditConfig">Edit Config File</button>
          <button class="btn btn-default btn-block" id="btnForceRefresh">Force Refresh</button>
        </div>
      </div>
    </div>
<?php
}
?>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Price Event</div>
        <div class="panel-body">
          <input type="text" id="dtEvent" name="daterange" class="form-control" style="width:100%" readonly>
          <div class="btn-group btn-group-justified" style="margin-top:10px">
            <div class="btn-group">
              <button class="btn btn-default" id="btnMarkSeason">Mark Season</button>
            </div>
            <div class="btn-group">
              <button class="btn btn-default" id="btnMarkHoliday">Mark Holiday</button>
            </div>
          </div>
          <button class="btn btn-default btn-block" id="btnRevertPromo">Revert</button>
        </div>
      </div>
    </div>
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
<?php
if ($account->checkUserLevel(3)) {
  ?>
<div id="modalEditConfig" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Edit Config File</h4>
      </div>
      <form id="frmEditConfig" class="form-horizontal">
        <div class="modal-body">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
<?php
$config = parse_ini_file(__DIR__ . "/../../../config.ini");
  foreach ($config as $name => $value) {
    echo "<div class='form-group'>
            <label class='col-sm-4 control-label'>" . ucwords(str_replace("_", " ", $name)) . "</label>
            <div class='col-sm-6'>";
    if ($value == "1" && $value == true && $name != "edit_reservation_days") {
      echo "<input type='checkbox' class='form-control' style='width:30px;height:30px' name='$name' checked/>";
      echo "<input type='hidden' name='$name' value='off'/>";
    } else if ($value == "" && $value == false) {
      echo "<input type='checkbox' class='form-control' style='width:30px;height:30px' name='$name'/>";
      echo "<input type='hidden' name='$name' value='off'/>";
    } else if ($value > 0) {
      echo "<input type='number' class='form-control' name='$name' value='$value'/>";
    } else {
      echo "<input type='text' class='form-control' name='$name' value='$value'/>";
    }

    echo "</div></div>";
  }
  ?>

        </div>
        <div class="modal-footer">
          <button id="btnSave" type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
}
?>
<?php require_once '../../../footer.php';?>