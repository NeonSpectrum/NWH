<?php
	if(isset($_POST['g-recaptcha-response'])){
		$captcha=$_POST['g-recaptcha-response'];
	}
	if(!$captcha){
		echo 'Please check the the captcha form.';
		exit;
	}
	$secretKey = "6Ler0DUUAAAAABE_r5gAH7LhkRPAavkyNkUOOQZd";
	$ip = $_SERVER['REMOTE_ADDR'];
	$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
	$responseKeys = json_decode($response,true);
	if(intval($responseKeys["success"]) !== 1) {
		echo 'You are spammer ! Get the @$%K out';
	}
?>