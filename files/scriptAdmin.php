<?php
	echo "<script src='".$root."../js/required/jquery.min.js?v=".filemtime($root.'../js/required/jquery.min.js')."'></script>\n";
	echo "<script src='".$root."../js/required/bootstrap.min.js?v=".filemtime($root.'../js/required/bootstrap.min.js')."'></script>\n";
	foreach (glob($root."../js/required/*.js") as $js) {
		if(strpos($js,"bootstrap") || strpos($js,"jquery"))
			continue;
		echo "<script src='".$js."?v=".filemtime($js)."'></script>\n";
	}
	foreach (glob("js/*.js") as $js) {
		echo "<script src='".$js."?v=".filemtime($js)."'></script>\n";
	}
	if($root!='')
	{
		foreach (glob("{$root}js/*.js") as $js) {
			echo "<script src='".$js."?v=".filemtime($js)."'></script>\n";
		}
	}
?>