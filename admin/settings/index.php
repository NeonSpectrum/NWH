<?php 
  require_once '../../header.php';
  if($_SESSION['accountType']=='User' || !isset($_SESSION['accountType']))
  {
    header('location: ../../../');
    exit();
  }
?>
<?php require_once '../../files/sidebar.php';?>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">Settings</h1>
    <div class="well">
      
    </div>
  </div>
</main>
<?php require_once '../../footer.php';?>