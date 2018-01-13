<?php
require_once '../../../header.php';
require_once '../../../files/sidebar.php';
?>
<main class="l-main">
  <div id="loadingMode" style="display:block"></div>
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
<div id="modalEditRoom" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">
        <form id="frmChangeRoom" class="form-horizontal">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>"/>
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
              <textarea id="txtDescription" name="txtDescription" type="text" class="form-control" style="resize:none" placeholder="Description" rows="5" required></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Simp. Description</label>
            <div class="col-sm-10">
              <textarea id="txtRoomSimpDesc" name="txtRoomSimpDesc" type="text" class="form-control" style="resize:none" placeholder="Description" rows="5" required></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Icons</label>
            <div class="col-sm-10">
              <textarea id="txtIcon" name="txtIcon" type="text" class="form-control" style="resize:none" placeholder="Description" rows="5" required></textarea>
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