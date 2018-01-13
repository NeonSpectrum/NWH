<?php
require_once '../../../header.php';
$system->checkUserLevel(2, true);
require_once '../../../files/sidebar.php';
?>
<main class="l-main">
  <div id="loadingMode" style="display:block"></div>
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">
      Event Logs
    </h1>
    <div class="well">
      <div class="table-responsive">
        <table id="tblEvents" class="table table-striped table-bordered table-hover">
          <thead>
            <th>ID</th>
            <th>Email Address</th>
            <th>Action</th>
            <th>Time Stamp</th>
          </thead>
          <tbody>
<?php
$view->eventLogs();
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
<?php require_once '../../../footer.php';?>