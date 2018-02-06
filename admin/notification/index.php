<?php
require_once '../../header.php';
require_once '../../files/sidebar.php';
?>
<main class="l-main">
  <div id="loadingMode" style="display:block"></div>
  <div class="content-wrapper content-wrapper--with-bg" style="overflow-y:hidden">
    <h1 class="page-title">Check</h1>
    <div class="well">
      <div class="table-responsive">
        <table id="tblNotification" class="table table-striped table-bordered table-hover">
          <thead>
            <th>ID</th>
            <th>Message</th>
            <th>TimeStamp</th>
          </thead>
          <tbody>
<?php
$view->notification();
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
<?php require_once '../../footer.php';?>