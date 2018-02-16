<?php
require_once '../header.php';
require_once '../files/sidebar.php'
;?>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">Dashboard</h1>
    <div class="row" style="text-align:center">
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">Accounts</div>
<?php
$query  = "SELECT count(*) as rows FROM account";
$result = mysqli_query($db, $query);
$row    = mysqli_fetch_assoc($result)['rows'];
?>
          <div class="panel-body">
            <?php echo $row; ?><br/>
          </div>
          <div class="panel-footer">
            <a href="<?php echo $root; ?>admin/settings/accounts">View more...</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">Books Ongoing Today</div>
<?php
$count  = 0;
$result = $db->query("SELECT * FROM booking LEFT JOIN booking_cancelled ON booking.BookingID=booking_cancelled.BookingID WHERE DateCancelled IS NULL");
while ($row = $result->fetch_assoc()) {
  $dates = $system->getDatesFromRange($row['CheckInDate'], date("Y-m-d", strtotime($row['CheckOutDate']) - 86400));
  if (in_array($date, $dates)) {
    $count++;
  }
}
?>
          <div class="panel-body">
<?php echo $count; ?><br/>
          </div>
          <div class="panel-footer">
            <a href="<?php echo $root; ?>admin/booking">View more...</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">Total Available Rooms</div>
          <div class="panel-body">
<?php echo count($room->generateRoomID(null, null, $date, date("Y-m-d", strtotime($date) + 86400), true)); ?><br/>
          </div>
          <div class="panel-footer">
            <a href="<?php echo $root; ?>admin/roomtable">View more...</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">Top Users</div>
          <div class="panel-body">
            <table style="width:100%">
<?php
$result = $db->query("SELECT FirstName, LastName, COUNT(BookingID) as NumberOfBooking FROM booking JOIN account ON booking.EmailAddress=account.EmailAddress GROUP BY FirstName, ' ', LastName ORDER BY NumberOfBooking DESC LIMIT 5");
for ($i = 1; $row = $result->fetch_assoc(); $i++) {
  echo "<tr><td align='center' width='20%'>Top {$i}</td><td width='60%'>{$row['FirstName']} {$row['LastName']}</td><td align='right' width='20%'>{$row['NumberOfBooking']} Book(s)</td></tr>";
}
?>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">Current Rating</div>
          <div class="panel-body">
<?php
$row = $db->query("SELECT COUNT(Star) AS Number, SUM(Star) as Total FROM feedback")->fetch_assoc();
echo $row['Number'] == null ? "N/A" : number_format($row['Total'] / $row['Number'], 1, ".", ",");
?>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">Rooms Chart</div>
          <div class="panel-body">
            <canvas id="roomChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">Booking Chart</div>
          <div class="panel-body">
            <canvas id="bookingChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">Walk In Chart</div>
          <div class="panel-body">
            <canvas id="walkInChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">Site Visitors Chart</div>
          <div class="panel-body">
            <canvas id="visitorChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php
require_once '../footer.php';
?>