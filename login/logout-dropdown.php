<?php
  $fname = isset($_SESSION["fname"]) ? $_SESSION["fname"] : '';
  $lname = isset($_SESSION["lname"]) ? $_SESSION["lname"] : '';
  $picture = isset($_SESSION["picture"]) ? $_SESSION["picture"] : '';
  $accounttype = isset($_SESSION["accounttype"]) ? $_SESSION["accounttype"] : '';
?>
<li class="dropdown">
  <a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer">
    <div class="user-icon-navbar" style="background-image: url('../images/profilepics/<?php echo $picture;?>');"></div>
      <div class="user-name-navbar">
        <?php echo $fname.' '.$lname;?>
      </div>
  <span class="caret"></span></a>
  <ul class="dropdown-menu" style="color:white;width:200px;">
      <?php
        if($accounttype == "Owner")
          echo "<li><a href='../admin/'>Admin Configuration</a></li>\n";
      ?>
      <li><a href="../login/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
  </ul>
</li>