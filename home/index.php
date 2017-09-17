<?php session_start();?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<title>Northwood Hotel</title>
  		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
      <?php 
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
    <div class="se-pre-con"></div>
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