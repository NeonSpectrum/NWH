<?php 
  require_once '../../../header.php';
  if($_SESSION['accountType']=='User' || !isset($_SESSION['accountType']))
  {
    header('location: ../../../');
    exit();
  }
?>
<?php require_once '../../../files/sidebar.php';?>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">List of Reservation</h1>
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
            </thead>
            <tbody>
              <?php
                $query = "SELECT walk_in.WalkInID, EmailAddress, RoomID, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children FROM walk_in LEFT JOIN reservation ON walk_in.WalkInID=reservation.WalkInID";
                $result = mysqli_query($db,$query) or die(mysql_error());
                while ($row = mysqli_fetch_assoc($result))
                {
                  echo "<tr>";
                  echo "<td>{$row['WalkInID']}</td>";
                  echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
                  echo "<td id='txtRoomID'>{$row['RoomID']}</td>";
                  echo "<td id='txtCheckIn'>{$row['CheckIn']}</td>";
                  echo "<td id='txtCheckOut'>{$row['CheckOut']}</td>";
                  echo "<td id='txtAdults'>{$row['Adults']}</td>";
                  echo "<td id='txtChildren'>{$row['Children']}</td>";
                  echo "</tr>";
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
            </thead>
            <tbody>
              <?php
                $query = "SELECT booking.BookingID, EmailAddress, RoomID, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children FROM booking LEFT JOIN reservation ON booking.BookingID=reservation.BookingID";
                $result = mysqli_query($db,$query) or die(mysql_error());
                while ($row = mysqli_fetch_assoc($result))
                {
                  echo "<tr>";
                  echo "<td>{$row['BookingID']}</td>";
                  echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
                  echo "<td id='txtRoomID'>{$row['RoomID']}</td>";
                  echo "<td id='txtCheckIn'>{$row['CheckIn']}</td>";
                  echo "<td id='txtCheckOut'>{$row['CheckOut']}</td>";
                  echo "<td id='txtAdults'>{$row['Adults']}</td>";
                  echo "<td id='txtChildren'>{$row['Children']}</td>";
                  echo "</tr>";
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
<?php require_once '../../../footer.php';?>