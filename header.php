<?php
// CONNECTING TO DATABASE
require_once 'files/autoload.php';

@session_start();

// IF ADMIN PAGE KICK IF NOT ADMIN
if (strpos(strtolower($_SERVER['PHP_SELF']), "admin")) {
  $system->checkUserLevel(1, true);
}

// GET CURRENT DIRECTORY EXAMPLE: home, gallery, roomandrates, contactus
$currentDirectory = substr(strtolower($_SERVER['PHP_SELF']), 0, strrpos(strtolower($_SERVER['PHP_SELF']), "/") + 1);
$currentDirectory = substr($currentDirectory, 0, -1);
$currentDirectory = substr($currentDirectory, strrpos($currentDirectory, "/") + 1);
$currentDirectory = $currentDirectory == str_replace("/", "", $root) ? 'home' : $currentDirectory;

?>
<!DOCTYPE html>
<html lang="en">
<head>

<title>Northwood Hotel</title>

<!-- META -->
<?php
require_once 'files/meta.php';
?>

<!-- WEBSITE ICON -->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $root; ?>favicon.ico?v=<?php echo filemtime(__DIR__ . "/favicon.ico"); ?>"/>
<link rel="apple-touch-icon" type="image/png" href="<?php echo $root; ?>images/logo-57.png?v=<?php echo filemtime(__DIR__ . "/images/logo-57.png"); ?>">
<link rel="apple-touch-icon" type="image/png" sizes="72x72" href="<?php echo $root; ?>images/logo-72.png?v=<?php echo filemtime(__DIR__ . "/images/logo-72.png"); ?>">
<link rel="apple-touch-icon" type="image/png" sizes="114x114" href="<?php echo $root; ?>images/logo-114.png?v=<?php echo filemtime(__DIR__ . "/images/logo-114.png"); ?>">
<link rel="icon" type="image/png" href="<?php echo $root; ?>images/logo-114.png?v=<?php echo filemtime(__DIR__ . "/images/logo-114.png"); ?>">

<!-- REQUIRED CSS -->
<?php
foreach (glob(__DIR__ . "/assets/css/required/*.css") as $css) {
  $file = str_replace(__DIR__ . "/", "", $css);
  echo "<link type='text/css' rel='stylesheet' href='{$root}$file?v=" . filemtime($css) . "'>\n";
}
?>

<!-- CUSTOM CSS -->
<?php
// GET MAIN OR ADMIN CSS
if (strpos(strtolower($_SERVER['PHP_SELF']), "admin")) {
  echo "<link type='text/css' rel='stylesheet' href='{$root}assets/css/admin.css?v=" . filemtime(__DIR__ . "/assets/css/admin.css") . "'>\n";
} else {
  echo "<link type='text/css' rel='stylesheet' href='{$root}assets/css/main.css?v=" . filemtime(__DIR__ . "/assets/css/main.css") . "'>\n";
}

// GET CURRENTDIRECTORY'S CSS
if (file_exists(__DIR__ . "/assets/css/$currentDirectory.css") && $currentDirectory != 'admin') {
  echo "<link type='text/css' rel='stylesheet' href='{$root}assets/css/$currentDirectory.css?v=" . filemtime(__DIR__ . "/assets/css/$currentDirectory.css") . "'>\n";
}

// IF ADMIN USE MINIMAL PACE
if (strpos(strtolower($_SERVER['PHP_SELF']), "admin")) {
  echo "<link type='text/css' rel='stylesheet' href='{$root}assets/css/pace-theme-minimal.css?v=" . filemtime(__DIR__ . '/assets/css/pace-theme-minimal.css') . "'>\n";
} else {
  echo "<link type='text/css' rel='stylesheet' id='pace' href='{$root}assets/css/pace-theme-center-simple.css?v=" . filemtime(__DIR__ . '/assets/css/pace-theme-center-simple.css') . "'>\n";
}
?>
</head>

<body<?php echo strpos(strtolower($_SERVER['PHP_SELF']), "/admin") ? ' class="sidebar-is-reduced"' : ''; ?>>

<?php
// IF NOT ADMIN DISPLAY LOADING ANIMATION
if (!strpos(strtolower($_SERVER['PHP_SELF']), "admin")) {
  echo "<div class='loadingIcon'><div id='loadingStatus'><noscript>Please enable Javascript to continue.</noscript></div></div>\n";

  // IF HOME DISABLE MARGIN TOP
  if ($currentDirectory != "home") {
    echo "<div class='height-navbar'></div>\n";
  }
  echo "<div id='alertBox'></div>\n";
}
?>