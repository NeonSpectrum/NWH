<?php
  $home = true;
  require '../files/header.php';
  require 'carousel.php';
  require '../files/navbar.php';
  /* if(isset($_SESSION["picture"]))
  {
    echo '<style>body{background: url("../images/profilepics/'.$_SESSION["picture"].'") no-repeat fixed;background-size:cover;}</style>';
  } */
?>
<div class="homeBody">
	<?php require 'bookNow.php';?>
	<div class="well center-block" style="width:80%;border-radius: 10px;">
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	</div>
</div>
<?php require '../files/footer.php';?>