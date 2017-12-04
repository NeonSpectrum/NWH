<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Welcome</title>
  <link rel='shortcut icon' href='../favicon.ico?<?php echo filemtime(__DIR__."/../favicon.ico")?>'/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href='https://fonts.googleapis.com/css?family=Raleway:200,400,800' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="../assets/css/required/animate.min.css">
  <link rel="stylesheet" href="../assets/css/required/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/css/required/normalize.min.css">
  <link rel="stylesheet" href="../assets/css/welcome.css">
</head>

<body style="height:100%;width:100%;user-select:none">
  <a class="proceed animated slideInUp" href="../" style="display:none;background-color:transparent;color:white;border-width:0;font-size:20px;position:fixed;bottom:0;right:0;z-index:9999;padding:20px;"><i class="fa fa-chevron-right fa-lg" aria-hidden="true"></i>  PROCEED TO THE WEBSITE</a>
  <div id="large-header" class="large-header">
    <canvas id="demo-canvas"></canvas>
    <h1 class="main-title animated zoomInDown" style="display:none">Northwood <span class="thin">Hotel</span></h1>
  </div>
  <script src="../assets/js/welcome.js"></script>
  <script src="../assets/js/required/1_jquery.min.js"></script>
  <script>
    $(window).on('load', function(){
      $('.main-title').show();
      $('.proceed').show();
    });
  </script>
</body>
</html>
