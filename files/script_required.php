<?php
	echo "<script src='/nwh/js/required/jquery.min.js'></script>\n";
	echo "<script src='/nwh/js/required/bootstrap.min.js'></script>\n";
	echo "<script src='/nwh/js/required/loader.js'></script>\n";
  foreach (glob("js/*.js") as $js) {
    echo "<script src='".$js."'></script>\n";
  }
  if(isset($links))
  {
    foreach (glob($links."js/*.js") as $js) {
      echo "<script src='".$js."'></script>\n";
    }
  }
?>