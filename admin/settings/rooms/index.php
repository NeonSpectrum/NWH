<?php
require_once '../../../header.php';
require_once '../../../files/sidebar.php';
?>
<main class="l-main">
  <div id="loadingMode" style="display:block"></div>
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">Room Management
      <div class="grp-buttons-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddRoom"><i class="fa fa-plus"></i>&nbsp;Room</button>
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddRoomType"><i class="fa fa-plus"></i>&nbsp;Room Type</button>
      </div>
    </h1>
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
              <th>Action</th>
            </thead>
            <tbody>
<?php
$view->rooms("statuses");
?>
            </tbody>
          </table>
        </div>
        <div id="roomtypes" class="tab-pane fade table-responsive">
          <table id="tblRoomTypes" class="table table-striped table-bordered table-hover" cellspacing="0">
            <thead>
              <th>Room Type</th>
              <th>Room Description</th>
              <th>Room Simplified Description</th>
              <th>Icons</th>
              <th>Capacity</th>
              <th>Regular Rate</th>
              <th>Season Rate</th>
              <th>Holiday Rate</th>
              <th>Action</th>
            </thead>
            <tbody>
<?php
$view->rooms("descriptions");
?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>
<div id="modalAddRoom" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Add Room</h4>
      </div>
      <form id="frmAddRoom" class="form-horizontal">
        <div class="modal-body">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Room Number</label>
            <div class="col-sm-9">
              <input id="txtRoomID" name="txtRoomID" type="text" class="form-control" required/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Room Type</label>
            <div class="col-sm-9">
              <select name="cmbRoomType" class="form-control">
<?php
foreach ($room->getRoomTypeList() as $roomType) {
  echo "<option value='$roomType'>" . str_replace("_", " ", $roomType) . "</option>";
}
?>
              </select>
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
<div id="modalAddRoomType" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Add Room Type</h4>
      </div>
      <form id="frmAddRoomType" class="form-horizontal">
        <div class="modal-body">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Room Type</label>
            <div class="col-sm-9">
              <input id="txtRoomType" name="txtRoomType" type="text" class="form-control" required/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Description</label>
            <div class="col-sm-9">
              <textarea id="txtDescription" name="txtDescription" type="text" class="form-control" style="resize:none" rows="5" required></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Simp. Description</label>
            <div class="col-sm-9">
              <textarea id="txtRoomSimpDesc" name="txtRoomSimpDesc" type="text" class="form-control" style="resize:none" rows="5" required></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Capacity:</label>
            <div class="col-sm-9">
             <input type="number" id="txtCapacity" name="txtCapacity" class="form-control"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Regular Rate:</label>
            <div class="col-sm-9">
             <input type="number" id="txtRegularRate" name="txtRegularRate" class="form-control"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Season Rate:</label>
            <div class="col-sm-9">
             <input type="number" id="txtSeasonRate" name="txtSeasonRate" class="form-control"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Holiday Rate:</label>
            <div class="col-sm-9">
             <input type="number" id="txtHolidayRate" name="txtHolidayRate" class="form-control"/>
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
<div id="modalEditRoomID" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <form id="frmEditRoomID" class="form-horizontal">
        <div class="modal-body">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Room Type</label>
            <div class="col-sm-9">
              <select id="cmbRoomType" name="cmbRoomType" class="form-control">
<?php
foreach ($room->getRoomTypeList() as $roomType) {
  echo "<option value='$roomType'>" . str_replace("_", " ", $roomType) . "</option>";
}
?>
              </select>
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
<div id="modalEditRoomType" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <form id="frmEditRoomType" class="form-horizontal">
        <div class="modal-body">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Description</label>
            <div class="col-sm-9">
              <textarea id="txtDescription" name="txtDescription" type="text" class="form-control" style="resize:none" rows="5" required></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Simp. Description</label>
            <div class="col-sm-9">
              <textarea id="txtRoomSimpDesc" name="txtRoomSimpDesc" type="text" class="form-control" style="resize:none" rows="5" required></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Icons</label>
            <div class="col-sm-9">
              <textarea id="txtIcon" name="txtIcon" type="text" class="form-control" style="resize:none" rows="5" required></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Capacity:</label>
            <div class="col-sm-9">
             <input type="number" id="txtCapacity" name="txtCapacity" class="form-control"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Regular Rate:</label>
            <div class="col-sm-9">
             <input type="number" id="txtRegularRate" name="txtRegularRate" class="form-control"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Season Rate:</label>
            <div class="col-sm-9">
             <input type="number" id="txtSeasonRate" name="txtSeasonRate" class="form-control"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Holiday Rate:</label>
            <div class="col-sm-9">
             <input type="number" id="txtHolidayRate" name="txtHolidayRate" class="form-control"/>
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
<?php require_once '../../../footer.php';?>