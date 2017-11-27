<?php 
  require_once '../../../header.php';
  if($_SESSION['accountType']=='User' || !isset($_SESSION['accountType']))
  {
    header('location: ../../../');
    exit();
  }
?>
<?php require_once '../../../files/sidebar.php';?>
<h2 class="text-center">Reservation</h2>
<div class="well center-block" id="reservation-body" style="width:85%">
  <table id="tblReservation" class="table table-striped table-bordered" cellspacing="0" style="display:none">
    <thead>
      <tr>
        <?php
          $query = "SHOW COLUMNS FROM booking";
          $result = mysqli_query($db,$query);
          while ($row = mysqli_fetch_assoc($result))
          {
            echo "<th>{$row['Field']}</th>\n";
          }
        ?>	
        <th>Report</th>
      </tr>
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
          echo "<td>{$row['Childrens']}</td>";
          echo "<td><a href='/files/generateReservationConfirmation.php?BookingID={$row['BookingID']}'>View Reservation</a></td>";
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>
</div>
<?php require_once '../../../footer.php';?>