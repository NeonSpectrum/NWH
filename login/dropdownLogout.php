<?php
  $fname = isset($_SESSION["fname"]) ? $_SESSION["fname"] : '';
  $lname = isset($_SESSION["lname"]) ? $_SESSION["lname"] : '';
  $picture = isset($_SESSION["picture"]) ? $_SESSION["picture"] : '';
  $accounttype = isset($_SESSION["accountType"]) ? $_SESSION["accountType"] : '';
?>
<li class="dropdown">
  <a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer">
    <div class="user-icon-navbar" style="background-image: url('/nwh/images/profilepics/<?php echo $picture;?>');"></div>
      <div class="user-name-navbar">
        <?php echo $fname.' '.$lname;?>
      </div>
  <span class="caret"></span></a>
  <ul class="dropdown-menu" style="color:white;width:200px;margin-top:-1px;margin-right:-1px;">
      <?php
        if($accounttype == "Owner" || $accounttype == "Admin")
          echo "<li><a href='/nwh/admin/'>Admin Configuration</a></li>\n";
      ?>
      <li><a href="/nwh/login/checklogout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
  </ul>
</li>