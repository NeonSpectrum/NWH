<?php
	echo "<script src='../js/required/jquery.min.js'></script>\n";
	echo "<script src='../js/required/bootstrap.min.js'></script>\n";
  foreach (glob("js/*.js") as $js) {
    echo "<script src='".$js."'></script>\n";
  }
?>