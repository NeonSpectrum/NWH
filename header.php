<?php
// EXECUTE AUTOLOAD SCRIPT
require_once 'files/autoload.php';

@session_start();
$csrf_token             = $system->encrypt(isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : md5(uniqid(rand(), TRUE)));
$_SESSION['csrf_token'] = $system->decrypt($csrf_token);

if (!isset($_SESSION['new_visitor'])) {
  $_SESSION['new_visitor'] = true;
  $system->addVisitorCount();
}

// GET CURRENT DIRECTORY EXAMPLE: home, gallery, roomandrates, contactus
$currentDirectory = str_replace("?{$_SERVER['QUERY_STRING']}", "", $_SERVER['REQUEST_URI']);
$currentDirectory = substr(strtolower($currentDirectory), @strrpos(strtolower($currentDirectory), "/", -2) + 1, -1);
if (!stripos($_SERVER['REQUEST_URI'], "admin")) {
  $currentDirectory = str_replace("nwh", "", $currentDirectory) == "" ? 'home' : $currentDirectory;
} else {
  $currentDirectory = $currentDirectory == "admin" ? 'dashboard' : $currentDirectory;
  $system->checkUserLevel(1, true);
}
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
if (stripos($_SERVER['REQUEST_URI'], "admin")) {
  echo "<link type='text/css' rel='stylesheet' href='{$root}assets/css/admin.css?v=" . filemtime(__DIR__ . "/assets/css/admin.css") . "'>\n";
} else {
  echo "<link type='text/css' rel='stylesheet' href='{$root}assets/css/main.css?v=" . filemtime(__DIR__ . "/assets/css/main.css") . "'>\n";
}

// GET CURRENTDIRECTORY'S CSS
if (file_exists(__DIR__ . "/assets/css/$currentDirectory.css") && $currentDirectory != 'admin') {
  echo "<link type='text/css' rel='stylesheet' href='{$root}assets/css/$currentDirectory.css?v=" . filemtime(__DIR__ . "/assets/css/$currentDirectory.css") . "'>\n";
}

// IF ADMIN USE MINIMAL PACE
if (stripos($_SERVER['REQUEST_URI'], "admin")) {
  echo "<link type='text/css' rel='stylesheet' href='{$root}assets/css/pace-theme-minimal.css?v=" . filemtime(__DIR__ . '/assets/css/pace-theme-minimal.css') . "'>\n";
} else {
  echo "<link type='text/css' rel='stylesheet' id='pace' href='{$root}assets/css/pace-theme-center-simple.css?v=" . filemtime(__DIR__ . '/assets/css/pace-theme-center-simple.css') . "'>\n";
}
?>
</head>

<body<?php echo stripos($_SERVER['REQUEST_URI'], "admin") ? ' class="sidebar-is-reduced"' : ''; ?>>

<?php
// IF NOT ADMIN DISPLAY LOADING ANIMATION
if (!stripos($_SERVER['REQUEST_URI'], "admin")) {
  echo "<div class='loadingIcon'><div id='loadingStatus'><noscript>Please enable Javascript to continue.</noscript></div></div>\n";

  // IF HOME DISABLE MARGIN TOP
  if ($currentDirectory != "home") {
    echo "<div class='height-navbar'></div>\n";
  }
  echo "<div id='alertBox'></div>\n";
}
?>