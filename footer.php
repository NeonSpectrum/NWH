	<?php
		if (!strpos($_SERVER['PHP_SELF'],"admin")) 
		{
	?>
	<div class="footer">
		<div class="center-block" style="width:80%;padding-left:10%;font-size:15px">
			<div class="footer-content">
				<hr style="border-color:white;border-width:3px;width:10%;" align="left"/>
				<a href="<?php echo strpos($_SERVER['PHP_SELF'],"contactus") ? '#googleMap' : '/contactus/#googleMap';?>" style="color:#333">No. 21 Quezon Ave. Poblacion, <br/>Alaminos City Pangasinan</a>
			</div>
			<div class="footer-content">
				<hr style="border-color:white;border-width:3px;width:10%;" align="left"/>
				Follow Us
				<br/>
				<a href="https://www.facebook.com/Northwoodhotel/"><img src="/images/fb.png" height="25px" width="25px"/></a>
			</div>
			<div class="footer-content">
				<hr style="border-color:white;border-width:3px;width:10%;" align="left"/>
				&copy; 2017 Northwood Hotel
				<br/><br/>
				(075) 636-0910 / (075) 205-0647<br/>
				0929-789-0088 / 0995-408-6292
			</div>
		</div>
	</div>
	<?php
		}
		foreach (glob(__DIR__."/assets/js/required/*.js") as $js) {
			$file = str_replace(__DIR__, "", $js);
			echo "<script src='$file?v=" . filemtime($js) . "'></script>\n";
		}
		if (strpos($_SERVER['PHP_SELF'],"admin")) {
			echo "<script src='/assets/js/admin.js?v=".filemtime(__DIR__."/assets/js/admin.js")."'></script>\n";
		} else {
			echo "<script src='/assets/js/main.js?v=".filemtime(__DIR__."/assets/js/main.js")."'></script>\n";
		}
	
		if (file_exists(__DIR__."/assets/js/$currentDirectory.js") && $currentDirectory != 'admin') {
			echo "<script src='/assets/js/$currentDirectory.js?v=".filemtime(__DIR__."/assets/js/$currentDirectory.js")."'></script>\n";
		}
		if ((isset($_SESSION['accountType']) && $_SESSION['accountType']!="Owner") || isset($_SESSION) || $_SERVER['SERVER_NAME'] != "localhost") {
			echo "<script src='/assets/js/verifyLoginSession.js?v=" . filemtime(__DIR__."/assets/js/verifyLoginSession.js") . "'></script>\n";
		}
	?>
	<script src='https://www.google.com/recaptcha/api.js'></script>
  </body>
</html>