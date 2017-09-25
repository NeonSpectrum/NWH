<ul class="nav navbar-nav navbar-right">
	<?php
		if(isset($_SESSION['email']))
		{
			include 'dropdownLogout.php';
			include 'modalEditReservation.php';
    }
  	else
  	{
			include 'modalRegistration.php';
			include 'modalForgot.php';
			include 'modalChange.php';
			include 'dropdownLogin.php';
    }
  ?>
</ul>