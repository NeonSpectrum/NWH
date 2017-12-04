<?php
  $dashboard = $booking = $chat = $settings = '';
  if (strpos($_SERVER['PHP_SELF'],'booking')) {
    $booking = ' is-active';
  } elseif (strpos($_SERVER['PHP_SELF'],'chat')) {
    $chat = ' is-active';
  } elseif (strpos($_SERVER['PHP_SELF'],'settings')) {
    $settings = ' is-active';
  } elseif (strpos($_SERVER['PHP_SELF'],'admin')) {
    $dashboard = ' is-active';
  }
?>
<header class="l-header">
  <div class="l-header__inner clearfix" style="user-select:none">
    <div class="c-header-icon js-hamburger">
      <div class="hamburger-toggle"><span class="bar-top"></span><span class="bar-mid"></span><span class="bar-bot"></span></div>
    </div>
    <div class="header-title">
      Admin Page
    </div>
    Logged in as: <span style="padding-left:5px;padding-right:10px;font-weight:bold"><?php echo "{$_SESSION['fname']} {$_SESSION['lname']}";?></span>
    <a id="btnGitUpdate" title="Update" style="cursor:pointer;text-decoration:none" class="c-header-icon"><i class="fa fa-cloud-download"></i></a>
    <a href="<?php echo $root;?>account/logout.php" title="Logout" style="text-decoration:none" class="c-header-icon"><i class="fa fa-power-off"></i></a>
  </div>
</header>
<div class="l-sidebar">
  <a class="logo" title="Go to home page" href="<?php echo $root;?>" style="text-decoration:none">
    <div class="logo__txt">NH</div>
  </a>
  <div class="l-sidebar__content">
    <nav class="c-menu js-menu">
      <ul class="u-list">
        <li class="c-menu__item <?php echo $dashboard;?>" title="Dashboard">
          <a class="c-menu__item__inner" href="<?php echo $root;?>admin"><i class="fa fa-id-card-o"></i>
            <div class="c-menu-item__title"><span>Dashboard</span></div>
          </a>
        </li>
        <li class="c-menu__item has-submenu <?php echo $booking;?>" title="Booking">
          <a class="c-menu__item__inner" href="<?php echo $root;?>admin/booking"><i class="fa fa-address-book-o"></i>
            <div class="c-menu-item__title"><span>Booking</span></div>
          </a>
        </li>
        <li class="c-menu__item has-submenu <?php echo $chat;?>" title="Chat">
          <a class="c-menu__item__inner" href="<?php echo $root;?>admin/chat"><i class="fa fa-comment-o"></i>
            <div class="c-menu-item__title"><span>Chat</span></div>
          </a>
        </li>
        <li class="c-menu__item has-submenu <?php echo $settings;?>" title="Settings">
          <a class="c-menu__item__inner"><i class="fa fa-cogs"></i>
            <div class="c-menu-item__title"><span>Settings</span></div>
            <div class="c-menu-item__expand js-expand-submenu"><i class="fa fa-angle-down"></i></div>
          </a>
          <ul class="c-menu__submenu u-list">
            <li title="Accounts">
              <a class="c-menu__item__inner" href="<?php echo $root;?>admin/settings/accounts"><i class="fa fa-user-circle-o"></i>
                <div class="c-menu-item__title"><span>Accounts</span></div>
              </a>
            </li>
            <li title="Room Management">
              <a class="c-menu__item__inner" href="<?php echo $root;?>admin/settings/rooms"><i class="fa fa-hotel"></i>
                <div class="c-menu-item__title"><span>Room Management</span></div>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>