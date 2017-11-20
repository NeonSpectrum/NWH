<ul class="nav navbar-nav navbar-right">
  <?php
    if(isset($_SESSION['email']))
    {
      require 'dropdownLogout.php';
    }
    else
    {
      require 'dropdownLogin.php';
    }
  ?>
</ul>