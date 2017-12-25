<?php
require_once '../header.php';
require_once '../files/navbar.php';
?>
<div class="container-fluid">
  <div class="well center-block" style="width:90%;background:rgba(255,255,255,0.9)">
    <h1 style="text-align:center">Room and Rates</h1>
    <hr style="border-color:black"/>
    <div class="table-responsive">
      <table>
<?php
if (!$db->connect_error) {
  $view->roomandrates();
}
?>
      </table>
    </div>
  </div>
</div>
<?php require_once '../footer.php';?>