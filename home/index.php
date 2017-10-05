<?php
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
	<div class="well center-block" style="width:80%;border-radius: 10px;opacity:0.9;">
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	</div>
</div>
<script>console.log('<?php ?>');</script>
<?php require '../files/footer.php';?>