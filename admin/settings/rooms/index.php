<?php
require_once '../../../header.php';
if ($_SESSION['accountType'] == 'User' || !isset($_SESSION['accountType'])) {
  header('location: ../../');
  exit();
}
?>
<?php require_once '../../../files/sidebar.php';?>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">Room Management</h1>
    <div class="well">
      <ul class="nav nav-tabs nav-justified">
        <li class="active"><a data-toggle="tab" href="#rooms">Rooms</a></li>
        <li><a data-toggle="tab" href="#roomtypes">Room Type</a></li>
      </ul>
      <div class="tab-content">
        <div id="rooms" class="tab-pane fade in active table-responsive">
          <table id="tblRooms" class="table table-striped table-bordered table-hover" cellspacing="0">
            <thead>
              <th>Room ID</th>
              <th>Room Type</th>
              <th>Switch</th>
            </thead>
            <tbody>
<?php
$query  = "SELECT RoomID, RoomType, RoomDescription, Status FROM room JOIN room_type ON room.RoomTypeID = room_type.RoomTypeID ORDER BY RoomID";
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>{$row['RoomID']}</td>";
  echo "<td>" . str_replace("_", " ", $row['RoomType']) . "</td>";
  $checked  = $row['Status'] == 'Enabled' || $row['Status'] == 'Occupied' ? 'checked' : '';
  $disabled = $row['Status'] == "Occupied" ? "data-onstyle='danger' disabled" : "";
  $status   = $row['Status'] == "Occupied" ? "Occupied" : "Enabled";
  echo "<td><input type='checkbox' data-toggle='toggle' data-on='$status' data-off='Disabled' class='cbxRoom' id='{$row['RoomID']}' $checked $disabled/></td>";
  echo "</tr>";
}
?>
            </tbody>
          </table>
        </div>
        <div id="roomtypes" class="tab-pane fade table-responsive">
          <table id="tblRoomTypes" class="table table-striped table-bordered table-hover" cellspacing="0">
            <thead>
              <th>Room Type</th>
              <th>Room Description</th>
              <th>Action</th>
            </thead>
            <tbody>
            <?php
$query  = "SELECT RoomType, RoomDescription FROM room_type";
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>" . str_replace("_", " ", $row['RoomType']) . "</td>";
  echo "<td style='width:60%' id='txtRoomDescription'>{$row['RoomDescription']}</td>";
  echo "<td style='width:20%'><a class='btnEditRoom' style='cursor:pointer' data-toggle='modal' data-target='#modalEditRoom' id='{$row['RoomType']}'><i class='fa fa-pencil' aria-hidden='true'></i></a></td>";
  echo "</tr>";
}
?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>
<div id="modalEditRoom" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">
        <form id="frmChangeRoom" class="form-horizontal">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                <textarea id="txtDescription" name="txtDescription" type="text" class="form-control" style="resize:none" placeholder="Description" rows="10" required></textarea>
              </div>
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
<?php require_once '../../../footer.php';?>