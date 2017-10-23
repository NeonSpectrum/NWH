<?php
	$root = isset($root) ? $root : '';
	echo "<link rel='shortcut icon' href='/nwh/favicon.ico'/>\n";
	foreach (glob("$root../css/required/*.css") as $css)
	{
		if(strpos($css,"pace")) continue;
		echo "<link type='text/css' rel='stylesheet' href='".$css."'>\n";
	}
	echo "<link type='text/css' rel='stylesheet' href='$root../css/required/pace-theme-center-simple.css'>\n";
	foreach (glob($root."../css/*.css") as $css)
	{
		echo "<link type='text/css' rel='stylesheet' href='".$css."'>\n";
	}
	foreach (glob("css/*.css") as $css)
	{
		echo "<link type='text/css' rel='stylesheet' href='".$css."'>\n";
	}
?>