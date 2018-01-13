<?php
require_once '../../header.php';
$system->checkUserLevel(1, true);
require_once '../../files/sidebar.php';
?>
<main class="l-main">
  <div id="loadingMode" style="display:block"></div>
  <div id="calendar"></div>
</main>
<?php require_once '../../footer.php';?>