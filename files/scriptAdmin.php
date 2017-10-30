<?php
	echo "<script src='".$root."../js/required/jquery.min.js?v=".filemtime($root.'../js/required/jquery.min.js')."'></script>\n";
	echo "<script src='".$root."../js/required/bootstrap.min.js?v=".filemtime($root.'../js/required/bootstrap.min.js')."'></script>\n";
	foreach (glob($root."../js/required/*.min.js") as $js) {
		if(strpos($js,"bootstrap.min.js") || strpos($js,"jquery.min.js")) continue;
		echo "<script src='".$js."?v=".filemtime($js)."'></script>\n";
	}
	foreach (glob($root."../js/required/*.js") as $js) {
		if(strpos($js,"min.js")) continue;
		echo "<script src='".$js."?v=".filemtime($js)."'></script>\n";
	}
	foreach (glob("js/*.js") as $js) {
		echo "<script src='".$js."?v=".filemtime($js)."'></script>\n";
	}
	if($root!='')
	{
		foreach (glob("{$root}js/*.js") as $js) {
			if(strpos($js,"verifyLoginSession") && (!isset($_SESSION['email']) || $_SERVER['SERVER_NAME'] == "localhost"))
				continue;
			echo "<script src='".$js."?v=".filemtime($js)."'></script>\n";
		}
	}
	echo "<script src='https://www.google.com/recaptcha/api.js'></script>\n";
?>