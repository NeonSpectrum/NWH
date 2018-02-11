<?php
require_once '../../header.php';
require_once '../../files/sidebar.php';
?>
<main class="l-main">
  <div id="loadingMode" style="display:block"></div>
  <div style="position:absolute;bottom:0;right:5px">
    Not Paid: <div style='display:inline-block;background-color:#3a87ad;height:10px;width:10px'></div> |
    Paid: <div style='display:inline-block;background-color:darkblue;height:10px;width:10px'></div> |
    Checked In: <div style='display:inline-block;background-color:red;height:10px;width:10px'></div> |
    Checked Out: <div style='display:inline-block;background-color:black;height:10px;width:10px'></div>
  </div>
  <div id="calendar"></div>
</main>
<?php require_once '../../footer.php';?>