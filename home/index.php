<?php include '../files/autologin.php';?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<title>Northwood Hotel</title>
      <?php 
        require '../files/meta.php';
        require '../files/db.php';
        require '../files/css.php';
      ;?>
	</head>
	<body>
    <?php
      if(isset($_SESSION["picture"]))
      {
        echo '<style>body{background: url("../images/profilepics/'.$_SESSION["picture"].'") no-repeat fixed;background-size:cover;}</style>';
      }  
    ?>
    <div class="loadingIcon"></div>
    <?php
      require 'carousel.php';
      require '../files/navbar.php';
    ?>
		<div class="container-fluid">
			<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		</div>
    <?php require '../files/script.php';?>
	</body>
</html>