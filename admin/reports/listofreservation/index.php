<?php
require_once '../../../header.php';
require_once '../../../files/sidebar.php';
?>
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
            <th>Check In Date</th>
            <th>Check Out Date</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Adults</th>
            <th>Children</th>
            <th>Total Amount</th>
          </thead>
          <tbody>
<?php
$view->listOfReservation();
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</main>
<?php require_once '../../../footer.php';?>