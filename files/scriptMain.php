<?php
	$root = isset($root) ? $root : '';
	echo "<script src='/nwh/js/required/jquery.min.js'></script>\n";
	echo "<script src='/nwh/js/required/bootstrap.min.js'></script>\n";
	echo "<script src='/nwh/js/required/main.js'></script>\n";
	foreach (glob($root."../js/*.js") as $js) {
		echo "<script src='".$js."'></script>\n";
	}
	foreach (glob($root."../login/js/*.js") as $js) {
		echo "<script src='".$js."'></script>\n";
	}
	foreach (glob("js/*.js") as $js) {
		echo "<script src='".$js."'></script>\n";
	}
?>