<?php
  session_start();
	if(session_destroy()) // Destroying All Sessions
	{
		header("location:".$_SERVER['HTTP_REFERER']); // Redirecting To Home Page
	}
?>