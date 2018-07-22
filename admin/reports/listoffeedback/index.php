<?php
require_once '../../../header.php';
require_once '../../../files/sidebar.php';
?>
<main class="l-main">
  <div id="loadingMode" style="display:block"></div>
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">List of Feedbacks</h1>
    <div class="well">
      <div class="table-responsive">
        <table id="tblFeedback" class="table table-striped table-bordered table-hover">
          <thead>
            <th>ID</th>
            <th>Star</th>
            <th>Comments and Suggestions</th>
          </thead>
          <tbody>
<?php
$view->listOfFeedback();
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</main>
<?php require_once '../../../footer.php';?>
