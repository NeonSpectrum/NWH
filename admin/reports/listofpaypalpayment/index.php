<?php
require_once '../../../header.php';
require_once '../../../files/sidebar.php';
?>
<main class="l-main">
  <div id="loadingMode" style="display:block"></div>
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">List of Paypal Payments</h1>
    <div class="well">
      <div class="table-responsive">
        <table id="tblPaypal" class="table table-striped table-bordered table-hover">
          <thead>
            <th>Booking ID</th>
            <th>Email Address</th>
            <th>Payer ID</th>
            <th>Payment ID</th>
            <th>Invoice Number</th>
            <th>PaymentAmount</th>
            <th>Time Stamp</th>
          </thead>
          <tbody>
<?php
$view->listOfPaypalPayment();
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</main>
<?php require_once '../../../footer.php';?>