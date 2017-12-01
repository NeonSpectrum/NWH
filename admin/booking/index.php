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
    <h1 class="page-title">Booking</h1>
    <div class="well">
      <table id="tblReservation" class="table table-striped table-bordered table-hover">
        <thead>
          <?php
            $query = "SHOW COLUMNS FROM booking";
            $result = mysqli_query($db,$query);
            while ($row = mysqli_fetch_assoc($result))
            {
              echo "<th>{$row['Field']}</th>\n";
            }
          ?>	
          <th>Report</th>
        </thead>
        <tbody>
          <?php
            $query = "SELECT * FROM booking";
            $result = mysqli_query($db,$query) or die(mysql_error());
            while ($row = mysqli_fetch_assoc($result))
            {
              echo "<tr>";
              echo "<td>{$row['BookingID']}</td>";
              echo "<td>{$row['EmailAddress']}</td>";
              echo "<td>{$row['RoomID']}</td>";
              echo "<td>{$row['CheckInDate']}</td>";
              echo "<td>{$row['CheckOutDate']}</td>";
              echo "<td>{$row['Adults']}</td>";
              echo "<td>{$row['Children']}</td>";
              echo "<td><a href='{$root}files/generateReservationConfirmation/?BookingID={$row['BookingID']}'>View Reservation</a></td>";
              echo "</tr>";
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<?php require_once '../../footer.php';?>