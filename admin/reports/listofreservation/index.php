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
// $view->listOfReservation("walk_in");
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
// $view->listOfReservation("book");
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