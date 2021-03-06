<?php
@session_start();
$csrf_token             = $system->encrypt(!isset($_SESSION['csrf_token']) || trim($_SESSION['csrf_token']) == '' ? md5(uniqid(rand(), TRUE)) : $_SESSION['csrf_token']);
$_SESSION['csrf_token'] = $system->decrypt($csrf_token);
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="token" content="<?php echo $csrf_token ?>">
<meta name="author" content="NeonSpectrum">
<meta name="keywords" content="Northwood, Northwood Hotel, Northwood Hotel Alaminos">
<meta name="description" content="One of the most exciting and amazing tourist destination in the Philippines, The Hundred Islands National Park in Alaminos, Pangasinan that covers 123 islands with 1,844 hectares. Northwood Hotel is just a few minutes away from Don Gonzalo Montemayor wharf in Barangay Lucap where you can rent a boat and start exploring the beautiful paradise of Governor’s Island, Quezon Island, Marcos Island, Children Island and some other islets.">
