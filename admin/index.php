<?php
  require_once '../header.php';
?>
<style>body{overflow-y:hidden}</style>
<?php require_once '../files/sidebar.php';?>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">Dashboard</h1>
    <div class="row" style="text-align:center">
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">Accounts</div>
          <?php
            $query = "SELECT count(*) as rows FROM account";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_assoc($result)['rows'];
          ?>
          <div class="panel-body">
            <?php echo $row;?><br/>
          </div>
          <div class="panel-footer">
            <a href="<?php echo $root;?>admin/settings/accounts">View more...</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">Books Ongoing</div>
          <?php
            $query = "SELECT count(*) as rows FROM booking WHERE CheckInDate >= CURDATE()";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_assoc($result)['rows'];
          ?>
          <div class="panel-body">
            <?php echo $row;?><br/>
          </div>
          <div class="panel-footer">
            <a href="<?php echo $root;?>admin/booking">View more...</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">Total Rooms</div>
          <?php
            $query = "SELECT count(*) as rows FROM room";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_assoc($result)['rows'];
          ?>
          <div class="panel-body">
            <?php echo $row;?><br/>
          </div>
          <div class="panel-footer">
            <a href="<?php echo $root;?>admin/settings/rooms">View more...</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">Chat Console</div>
          <div class="panel-body">
            
          </div>
          <div class="panel-footer">
            <a href="<?php echo $root;?>admin/chat">View more...</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php 
  require_once '../footer.php';
?>