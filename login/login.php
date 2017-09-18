<ul class="nav navbar-nav navbar-right">
	<?php
		$logged = isset($_SESSION["logged"]) ? $_SESSION["logged"] : false;
		if($logged)
		{
        include 'logout-dropdown.php';
    }
  	else
  	{
        include 'registrationModal.php';
        include 'forgotModal.php';
        include 'changeModal.php';
        include 'loginform.php';
    }
  ?>
</ul>