<ul class="nav navbar-nav navbar-right">
	<?php
		$logged = isset($_SESSION["logged"]) ? $_SESSION["logged"] : false;
		if($logged)
		{
				$fname = isset($_SESSION["fname"]) ? $_SESSION["fname"] : '';
				$lname = isset($_SESSION["lname"]) ? $_SESSION["lname"] : '';
		    echo '<li class="dropdown" style="color:white;margin:15px;">'.$fname.' '.$lname.'</li>';
		    echo '<li class="dropdown"><a href="../login/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';
    }
  	else
  	{
        include 'registrationModal.php';
        include 'loginform.php';
    }
  ?>
</ul>