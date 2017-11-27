<?php
  require_once '../header.php';
  if ($_SESSION['accountType']=='User' || !isset($_SESSION['accountType'])) {
    header('location: ../');
    exit();
  }
?>
<style>body{overflow-y:hidden}</style>
<?php require_once '../files/sidebar.php';?>
<div class="well center-block text-center" id="admin-body">
  Welcome, <?php echo $_SESSION['fname'].' '.$_SESSION['lname'];?><br/>to the<br/>Admin Page<br/>of<br/>Northwood Hotel
</div>
<?php
  if ($_SERVER['SERVER_NAME']=="neonspectrum.redirectme.net") {
?>
<div style="position:fixed;bottom:5px;right:5px;">
  <button type="submit" class="btn btn-default" id="btnGitUpdate">Update Website</button>
</div>
<?php 
  }
  require_once '../footer.php';
?>