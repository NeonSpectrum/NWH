<?php
require_once '../../../header.php';
$system->checkUserLevel(1, true);
?>
<?php require_once '../../../files/sidebar.php';?>
<main class="l-main">
  <div id="loadingMode" style="display:block"></div>
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">List of Reservation</h1>
    <div class="well">
      <div class="table-responsive">
        <table id="tblBooking" class="table table-striped table-bordered table-hover">
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
$view->listOfReservation("booking");
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</main>
<?php require_once '../../../footer.php';?>