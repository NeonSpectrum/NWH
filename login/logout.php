<?php
  session_start();
	if(session_destroy()) // Destroying All Sessions
	{
    if(isset($link))
      header("location:'$link'"); 
		header("location:".$_SERVER['HTTP_REFERER']); // Redirecting To Home Page
	}
?>