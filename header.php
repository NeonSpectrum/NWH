<?php
  // IF SESSION NOT EXISTS, START 
  if(!isset($_SESSION)) session_start();

  // CONNECTING TO DATABASE
  require_once 'files/db.php';

  // GET CURRENT DIRECTORY EXAMPLE: gallery, roomandrates, contactus
  $currentDirectory = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'],"/") + 1);
  $currentDirectory = substr($currentDirectory, 0, -1);
  $currentDirectory = substr($currentDirectory, strrpos($currentDirectory, "/") + 1);
  $currentDirectory = $currentDirectory == '' || $currentDirectory == 'nwh' ? 'home' : $currentDirectory;
  
  // TEMPORARY FOR DOMAINS WITH /nwh/
  $root = substr($_SERVER['PHP_SELF'], 0, 5) == '/nwh/' ? '/nwh/' : '/';
?>
<!DOCTYPE html>
<html lang="en">
<head>

<title>Northwood Hotel</title>

<!-- WEBSITE ICON -->
<link rel='shortcut icon' href='<?php echo $root;?>favicon.ico'/>

<!-- META -->
<?php 
  require_once 'files/meta.php';
  echo "\n";
?>

<!-- REQUIRED CSS -->
<?php
  foreach (glob(__DIR__."/assets/css/required/*.css") as $css) {
    $file = str_replace(__DIR__."/", "", $css);
    echo "<link type='text/css' rel='stylesheet' href='{$root}$file?v=" . filemtime($css) . "'>\n";
  }
?>

<!-- CUSTOM CSS -->
<?php
  // GET MAIN OR ADMIN CSS
  if (strpos($_SERVER['PHP_SELF'],"admin")) {
    echo "<link type='text/css' rel='stylesheet' href='{$root}assets/css/admin.css?v=".filemtime(__DIR__."/assets/css/admin.css")."'>\n";
  } else {
    echo "<link type='text/css' rel='stylesheet' href='{$root}assets/css/main.css?v=".filemtime(__DIR__."/assets/css/main.css")."'>\n";
  }

  // GET CURRENTDIRECTORY'S CSS
  if (file_exists(__DIR__."/assets/css/$currentDirectory.css") && $currentDirectory != 'admin') {
    echo "<link type='text/css' rel='stylesheet' href='{$root}assets/css/$currentDirectory.css?v=".filemtime(__DIR__."/assets/css/$currentDirectory.css")."'>\n";
  }

  // IF ADMIN USE MINIMAL PACE
  if (strpos($_SERVER['PHP_SELF'],"admin")) {
    echo "<link type='text/css' rel='stylesheet' href='{$root}assets/css/pace-theme-minimal.css?v=".filemtime(__DIR__.'/assets/css/pace-theme-minimal.css') . "'>\n";
  } else {
    echo "<link type='text/css' rel='stylesheet' id='pace' href='{$root}assets/css/pace-theme-center-simple.css?v=".filemtime(__DIR__.'/assets/css/pace-theme-center-simple.css') . "'>\n";
  }
?>
<link type='text/css' rel='stylesheet' href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

</head>

<body>

<?php
  // IF NOT ADMIN DISPLAY LOADING ANIMATION
  if (!strpos($_SERVER['PHP_SELF'],"admin")) {
    echo "<div class='loadingIcon'><noscript><span style='position:fixed;z-index:9999'>Please enable Javascript to continue.</span></noscript></div>\n";
    
    // IF HOME DISABLE MARGIN TOP
    if ($currentDirectory != "home")
      echo "<div class='height-navbar'></div>\n";
    echo "<a href='#' class='back-to-top'>Back to Top</a>\n";
  }
?>
<div id="alertBox"></div>
