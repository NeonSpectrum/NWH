<?php
require_once '../../header.php';
if ($_SESSION['accountType'] == 'User' || !isset($_SESSION['accountType'])) {
  header('location: ../../../');
  exit();
}
?>
<?php require_once '../../files/sidebar.php';?>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">
      Booking
      <span class="pull-right">
        <a style="cursor:pointer" href="<?php echo $root; ?>reservation"><span class="fa fa-plus"></span></a>
      </span>
    </h1>
    <div class="well">
      <div class="table-responsive">
        <table id="tblReservation" class="table table-striped table-bordered table-hover">
          <thead>
            <th>Booking ID</th>
            <th>Email Address</th>
            <th>Room ID</th>
            <th>Check In Date</th>
            <th>Check Out Date</th>
            <th>Adults</th>
            <th>Children</th>
            <th>Action</th>
          </thead>
          <tbody>
            <?php
$query  = "SELECT * FROM booking";
$result = mysqli_query($db, $query) or die(mysql_error());
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>{$row['BookingID']}</td>";
  echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
  echo "<td id='txtRoomID'>{$row['RoomID']}</td>";
  echo "<td id='txtCheckInDate'>{$row['CheckInDate']}</td>";
  echo "<td id='txtCheckOutDate'>{$row['CheckOutDate']}</td>";
  echo "<td id='txtAdults'>{$row['Adults']}</td>";
  echo "<td id='txtChildren'>{$row['Children']}</td>";
  echo "<td>";
  echo "<a class='btnEditReservation' id='{$row['BookingID']}' style='cursor:pointer' data-toggle='modal' data-target='#modalEditReservation'><i class='fa fa-pencil'></i></a>";
  echo "&nbsp;&nbsp;<a href='{$root}files/generateReservationConfirmation/?BookingID={$row['BookingID']}' title='Print'><i class='fa fa-print'></i></a>";
  echo "</td>";
  echo "</tr>";
}
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
<div id="modalEditReservation" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Edit Reservation</h4>
      </div>
      <div class="modal-body">
        <form id="frmEditReservation" method="post" class="form-horizontal">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" id="cmbBookingID" name="cmbBookingID">
          <div class="form-group">
            <label class="col-sm-3 control-label">Room Type</label>
            <div class="col-sm-3">
              <select id="cmbRoomType" name="cmbRoomType" class="form-control">
                <option>Standard Single</option>
                <option>Standard Double</option>
                <option>Family Room</option>
                <option>Junior Suites</option>
                <option>Studio Type</option>
                <option>Barkada Room</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Check In Date</label>
            <div class="col-sm-7">
              <div class="input-group date">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input name="txtCheckInDate" type="text" class="form-control checkInDate" id="txtCheckInDate" required readonly/>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Check Out Date</label>
            <div class="col-sm-7">
              <div class="input-group date">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input name="txtCheckOutDate" type="text" class="form-control checkOutDate" id="txtCheckOutDate" required readonly/>
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