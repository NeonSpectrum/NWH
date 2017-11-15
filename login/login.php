<ul class="nav navbar-nav navbar-right">
  <?php
    if(isset($_SESSION['email']))
    {
      require 'dropdownLogout.php';
      require 'modalEditReservation.php';
      require 'modalEditProfile.php';
      require 'modalChange.php';
    }
    else
    {
      require 'dropdownLogin.php';
      require 'modalRegistration.php';
      require 'modalForgot.php';
    }
  ?>
</ul>