<?php
	echo "<script src='/nwh/js/required/jquery.min.js'></script>\n";
	echo "<script src='/nwh/js/required/bootstrap.min.js'></script>\n";
	foreach (glob($root."../js/required/*.js") as $js) {
		if(strpos($js,"bootstrap") || strpos($js,"jquery"))
			continue;
		echo "<script src='".$js."'></script>\n";
	}
	foreach (glob("js/*.js") as $js) {
		echo "<script src='".$js."'></script>\n";
	}
	if($root!='')
	{
		foreach (glob($root."js/*.js") as $js) {
			echo "<script src='".$js."'></script>\n";
		}
	}
?>