<?php 
  require_once '../../header.php';
  if($_SESSION['accountType']=='User' || !isset($_SESSION['accountType']))
  {
    header('location: ../../../');
    exit();
  }
?>
<?php require_once '../../files/sidebar.php';?>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">
      Check
      <span class="pull-right">
        <a style="cursor:pointer" data-toggle="modal" data-target="#modalAddReservation"><span class="fa fa-plus"></span></a>
      </span>
    </h1>
    <div class="well">
      <ul class="nav nav-tabs nav-justified">
        <li class="active"><a data-toggle="tab" href="#walkin">Walk In</a></li>
        <li><a data-toggle="tab" href="#book">Book</a></li>
      </ul>
      <div class="tab-content" style="margin-top:20px">
        <div id="walkin" class="tab-pane fade in active">
          <div class="table-responsive">  
            <table id="tblWalkIn" class="table table-striped table-bordered table-hover">
              <thead>
                <th>Walk In ID</th>
                <th>Email Address</th>
                <th>Room ID</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Adults</th>
                <th>Children</th>
                <th>Action</th>
              </thead>
              <tbody>
                <?php
                  $query = "SELECT walk_in.WalkInID, EmailAddress, RoomID, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children FROM walk_in LEFT JOIN reservation ON walk_in.WalkInID=reservation.WalkInID";
                  $result = mysqli_query($db,$query) or die(mysql_error());
                  while ($row = mysqli_fetch_assoc($result))
                  {
                    $checkInStatus = $row['CheckIn'] == '' ? false : true;
                    $checkOutStatus = $row['CheckOut'] == '' ? false : true;
                    if (strtotime(date('Y-m-d')) == strtotime($row['CheckInDate']) && !($checkInStatus && $checkOutStatus)){
                      echo "<tr>";
                      echo "<td>{$row['WalkInID']}</td>";
                      echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
                      echo "<td id='txtRoomID'>{$row['RoomID']}</td>";
                      echo "<td id='txtCheckIn'>{$row['CheckIn']}</td>";
                      echo "<td id='txtCheckOut'>{$row['CheckOut']}</td>";
                      echo "<td id='txtAdults'>{$row['Adults']}</td>";
                      echo "<td id='txtChildren'>{$row['Children']}</td>";
                      echo "<td>";
                      echo "<a title='Check In' class='btnCheckIn' id='{$row['WalkInID']}' style='cursor:pointer'";
                      echo $checkInStatus ? ' disabled' : '';
                      echo "><i class='fa fa-calendar-plus-o'></i></a>";
                      echo "&nbsp;&nbsp;<a title='Check Out' class='btnCheckOut' id='{$row['WalkInID']}' style='cursor:pointer'";
                      echo $checkOutStatus ? ' disabled' : '';
                      echo "><i class='fa fa-calendar-minus-o'></i></a>";
                      echo "</td>";
                      echo "</tr>";
                    }
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div id="book" class="tab-pane fade">
          <div class="table-responsive">
            <table id="tblBook" class="table table-striped table-bordered table-hover">
              <thead>
                <th>Booking ID</th>
                <th>Email Address</th>
                <th>Room ID</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Adults</th>
                <th>Children</th>
                <th>Action</th>
              </thead>
              <tbody>
                <?php
                  $query = "SELECT booking.BookingID, EmailAddress, RoomID, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children FROM booking LEFT JOIN reservation ON booking.BookingID=reservation.BookingID";
                  $result = mysqli_query($db,$query) or die(mysql_error());
                  while ($row = mysqli_fetch_assoc($result))
                  {
                    $checkInStatus = $row['CheckIn'] == '' ? false : true;
                    $checkOutStatus = $row['CheckOut'] == '' ? false : true;
                    if (strtotime(date('Y-m-d')) == strtotime($row['CheckInDate']) && !($checkInStatus && $checkOutStatus)){
                      echo "<tr>";
                      echo "<td>{$row['BookingID']}</td>";
                      echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
                      echo "<td id='txtRoomID'>{$row['RoomID']}</td>";
                      echo "<td id='txtCheckIn'>{$row['CheckIn']}</td>";
                      echo "<td id='txtCheckOut'>{$row['CheckOut']}</td>";
                      echo "<td id='txtAdults'>{$row['Adults']}</td>";
                      echo "<td id='txtChildren'>{$row['Children']}</td>";
                      echo "<td>";
                      echo "<a title='Check In' class='btnCheckIn' id='{$row['BookingID']}' style='cursor:pointer'";
                      echo $checkInStatus ? ' disabled' : '';
                      echo "><i class='fa fa-calendar-plus-o'></i></a>";
                      echo "&nbsp;&nbsp;<a title='Check Out' class='btnCheckOut' id='{$row['BookingID']}' style='cursor:pointer'";
                      echo $checkOutStatus ? ' disabled' : '';
                      echo "><i class='fa fa-calendar-minus-o'></i></a>";
                      echo "</td>";
                      echo "</tr>";
                    }
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<div id="modalAddReservation" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Add Reservation</h4>
      </div>
      <div class="modal-body">
        <form id="frmAddReservation" method="post" class="form-horizontal">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Email Address</label>
            <div class="col-sm-8">
              <select name="txtEmail" class="form-control" id="txtEmail">
                <?php
                  $query = "SELECT * FROM account";
                  $result = mysqli_query($db, $query);
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option>{$row['EmailAddress']}</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Room Type</label>
            <div class="col-sm-8">
              <!-- <input name="txtRoomID" type="text" class="form-control" id="txtRoomID" placeholder="Room ID" required/> -->
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
            <button id="btnReservation" type="submit" class="btn btn-info">Add</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
   </div>
</div>
<?php require_once '../../footer.php';?>