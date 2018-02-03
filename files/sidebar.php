<?php
$dashboard = $calendar = $roomtable = $booking = $check = $chat = $reports = $settings = '';
if (strpos($_SERVER['PHP_SELF'], 'calendar')) {
  $calendar = ' is-active';
} elseif (strpos($_SERVER['PHP_SELF'], 'roomtable')) {
  $roomtable = ' is-active';
} elseif (strpos($_SERVER['PHP_SELF'], 'booking') && !strpos($_SERVER['PHP_SELF'], 'listofcancelledbooking')) {
  $booking = ' is-active';
} elseif (strpos($_SERVER['PHP_SELF'], 'check')) {
  $check = ' is-active';
} elseif (strpos($_SERVER['PHP_SELF'], 'chat')) {
  $chat = ' is-active';
} elseif (strpos($_SERVER['PHP_SELF'], 'reports')) {
  $reports = ' is-active';
} elseif (strpos($_SERVER['PHP_SELF'], 'settings')) {
  $settings = ' is-active';
} elseif (strpos($_SERVER['PHP_SELF'], 'admin')) {
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
    Logged in as: <div class="user-icon-navbar" style="background-image: url('<?php echo $root; ?>images/profilepics/?email=<?php echo $account->email; ?>');background-position:center;"></div><span style="padding-left:5px;padding-right:10px;font-weight:bold"><?php echo "{$account->firstName} {$account->lastName}"; ?></span>
<?php
if ($account->checkUserLevel(3)) {
  ?>
    <a id="btnGitUpdate" data-tooltip="tooltip" data-placement="bottom" title="Update" style="cursor:pointer;text-decoration:none" class="c-header-icon"><i class="fa fa-cloud-download"></i></a>
<?php
}
?>
    <a id="btnLogout" data-tooltip="tooltip" data-placement="bottom" title="Logout" style="text-decoration:none;cursor:pointer" class="c-header-icon"><i class="fa fa-power-off"></i></a>
  </div>
</header>
<div class="l-sidebar">
  <a class="logo" data-tooltip="tooltip" data-placement="right" title="Go to home page" href="<?php echo $root; ?>" style="text-decoration:none">
    <div class="logo__txt">NWH</div>
  </a>
  <div class="l-sidebar__content">
    <nav class="c-menu js-menu">
      <ul class="u-list">
        <li class="c-menu__item <?php echo $dashboard; ?>">
          <a class="c-menu__item__inner" href="<?php echo $root; ?>admin" data-tooltip="tooltip" data-placement="right" title="Dashboard"><i class="fa fa-id-card-o"></i>
            <div class="c-menu-item__title"><span>Dashboard</span></div>
          </a>
        </li>
        <li class="c-menu__item has-submenu <?php echo $calendar; ?>">
          <a class="c-menu__item__inner" href="<?php echo $root; ?>admin/calendar" data-tooltip="tooltip" data-placement="right" title="Calendar"><i class="fa fa-calendar"></i>
            <div class="c-menu-item__title"><span>Calendar</span></div>
          </a>
        </li>
        <li class="c-menu__item has-submenu <?php echo $roomtable; ?>">
          <a class="c-menu__item__inner" href="<?php echo $root; ?>admin/roomtable" data-tooltip="tooltip" data-placement="right" title="Room Table"><i class="fa fa-home"></i>
            <div class="c-menu-item__title"><span>Room Table</span></div>
          </a>
        </li>
        <li class="c-menu__item has-submenu <?php echo $booking; ?>">
          <a class="c-menu__item__inner" href="<?php echo $root; ?>admin/booking" data-tooltip="tooltip" data-placement="right" title="Booking"><i class="fa fa-address-book-o"></i>
            <div class="c-menu-item__title"><span>Booking</span></div>
          </a>
        </li>
        <li class="c-menu__item has-submenu <?php echo $check; ?>">
          <a class="c-menu__item__inner" href="<?php echo $root; ?>admin/check" data-tooltip="tooltip" data-placement="right" title="Check"><i class="fa fa-calendar-check-o"></i>
            <div class="c-menu-item__title"><span>Check</span></div>
          </a>
        </li>
<?php
if (CHAT) {
  ?>
        <li class="c-menu__item has-submenu <?php echo $chat; ?>">
          <a class="c-menu__item__inner" href="<?php echo $root; ?>admin/chat" data-tooltip="tooltip" data-placement="right" title="Chat"><i class="fa fa-comment-o"></i>
            <div class="c-menu-item__title"><span>Chat</span></div>
          </a>
        </li>
<?php
}
?>
        <li class="c-menu__item has-submenu <?php echo $reports; ?>">
          <a class="c-menu__item__inner" data-tooltip="tooltip" data-placement="right" title="Reports"><i class="fa fa-bar-chart"></i>
            <div class="c-menu-item__title"><span>Reports</span></div>
            <div class="c-menu-item__expand js-expand-submenu"><i class="fa fa-angle-down"></i></div>
          </a>
          <ul class="c-menu__submenu u-list">
            <li>
              <a class="c-menu__item__inner" href="<?php echo $root; ?>admin/reports/listofreservation" data-tooltip="tooltip" data-placement="right" title="List Of Reservation"><i class="fa fa-book"></i>
                <div class="c-menu-item__title"><span>List of Reservation</span></div>
              </a>
            </li>
          </ul>
          <ul class="c-menu__submenu u-list">
            <li>
              <a class="c-menu__item__inner" href="<?php echo $root; ?>admin/reports/listofcancelledbooking" data-tooltip="tooltip" data-placement="right" title="List Of Cancelled Booking"><i class="fa fa-ban"></i>
                <div class="c-menu-item__title"><span>List of Cancelled Booking</span></div>
              </a>
            </li>
          </ul>
<?php
if (ALLOW_PAYPAL == true) {
  ?>
          <ul class="c-menu__submenu u-list">
            <li>
              <a class="c-menu__item__inner" href="<?php echo $root; ?>admin/reports/listofpaypalpayment" data-tooltip="tooltip" data-placement="right" title="List Of Paypal Payments"><i class="fa fa-money"></i>
                <div class="c-menu-item__title"><span>List of Paypal Payments</span></div>
              </a>
            </li>
          </ul>
<?php
}
?>
        </li>
        <li class="c-menu__item has-submenu <?php echo $settings; ?>">
          <a class="c-menu__item__inner" data-tooltip="tooltip" data-placement="right" title="Settings"><i class="fa fa-cogs"></i>
            <div class="c-menu-item__title"><span>Settings</span></div>
            <div class="c-menu-item__expand js-expand-submenu"><i class="fa fa-angle-down"></i></div>
          </a>
          <ul class="c-menu__submenu u-list">
            <li>
              <a class="c-menu__item__inner" href="<?php echo $root; ?>admin/settings/accounts" data-tooltip="tooltip" data-placement="right" title="Accounts"><i class="fa fa-user-circle-o"></i>
                <div class="c-menu-item__title"><span>Accounts</span></div>
              </a>
            </li>
            <li>
              <a class="c-menu__item__inner" href="<?php echo $root; ?>admin/settings/rooms" data-tooltip="tooltip" data-placement="right" title="Room Management"><i class="fa fa-hotel"></i>
                <div class="c-menu-item__title"><span>Room Management</span></div>
              </a>
            </li>
<?php
if ($account->checkUserLevel(3)) {
  ?>
            <li>
              <a class="c-menu__item__inner" href="<?php echo $root; ?>admin/settings/eventlogs" data-tooltip="tooltip" data-placement="right" title="Event Logs"><i class="fa fa-database"></i>
                <div class="c-menu-item__title"><span>Event Logs</span></div>
              </a>
            </li>
<?php
}
if ($account->checkUserLevel(2)) {
  ?>
            <li>
              <a class="c-menu__item__inner" href="<?php echo $root; ?>admin/settings/cpanel" data-tooltip="tooltip" data-placement="right" title="Control Panel"><i class="fa fa-sliders"></i>
                <div class="c-menu-item__title"><span>Control Panel</span></div>
              </a>
            </li>
<?php
}
?>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>