<?php
require_once '../../../header.php';
$system->checkUserLevel(3, true);
require_once '../../../files/sidebar.php';
?>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">Control Panel</h1>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Send to All</div>
        <div class="panel-body">
          <form id="frmSendToAllAdmin">
            Message: <input type="text" name="txtMessage" class="form-control"><br/>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
<?php require_once '../../../footer.php';?>