<?php
require_once '../header.php';
$system->checkUserLevel(1, true);
?>
<?php require_once '../files/sidebar.php';?>
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
$query  = "SELECT count(*) as rows FROM booking WHERE CheckInDate >= CURDATE() AND CheckOutDate <= CURDATE()";
$result = mysqli_query($db, $query);
$row    = mysqli_fetch_assoc($result)['rows'];
?>
          <div class="panel-body">
<?php echo $row; ?><br/>
          </div>
          <div class="panel-footer">
            <a href="<?php echo $root; ?>admin/booking">View more...</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">Total Available Rooms</div>
<?php
$row = count($room->generateRoomID(null, null, $date, $date));
?>
          <div class="panel-body">
<?php echo $row; ?><br/>
          </div>
          <div class="panel-footer">
            <a href="<?php echo $root; ?>admin/settings/rooms">View more...</a>
          </div>
        </div>
      </div>
<?php
if (CHAT) {
  ?>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">Chat Console</div>
          <div class="panel-body">

          </div>
          <div class="panel-footer">
            <a href="<?php echo $root; ?>admin/chat">View more...</a>
          </div>
        </div>
      </div>
<?php
}
?>
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
          <div class="panel-heading">Site Visitors Chart</div>
          <div class="panel-body">
            <canvas id="visitorChart"></canvas>
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
    </div>
  </div>
</main>
<?php

require_once '../footer.php';
?>