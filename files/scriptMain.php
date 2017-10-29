<?php
	$root = isset($root) ? $root : '';
	echo "<script src='".$root."../js/required/jquery.min.js?v=".filemtime($root.'../js/required/jquery.min.js')."'></script>\n";
	echo "<script src='".$root."../js/required/bootstrap.min.js?v=".filemtime($root.'../js/required/bootstrap.min.js')."'></script>\n";
	foreach (glob($root."../js/required/*.js") as $js) {
		if(strpos($js,"bootstrap.min") || strpos($js,"jquery"))
			continue;
		echo "<script src='".$js."?v=".filemtime($js)."'></script>\n";
	}
	foreach (glob("../js/*.js") as $js) {
		if(strpos($js,"verifyLoginSession") && !isset($_SESSION['email']))
			continue;
		echo "<script src='".$js."?v=".filemtime($js)."'></script>\n";
	}
	foreach (glob($root."../login/js/*.js") as $js) {
		echo "<script src='".$js."?v=".filemtime($js)."'></script>\n";
	}
	foreach (glob("js/*.js") as $js) {
		echo "<script src='".$js."?v=".filemtime($js)."'></script>\n";
	}
	echo "<script src='https://www.google.com/recaptcha/api.js'></script>\n";
?>