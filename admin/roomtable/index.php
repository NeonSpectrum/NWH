<?php
require_once '../../header.php';
$system->checkUserLevel(1, true);
require_once '../../files/sidebar.php';

$roomList  = $room->getRoomIDList();
$roomUsing = $room->getUsingRoomList();
$room      = [];
foreach ($roomList as $value) {
  if (in_array($value, $roomUsing)) {
    $room[$value] = "using";
  } else {
    $room[$value] = "available";
  }
}
?>
<main class="l-main">
  <!-- <div id="loadingMode" style="display:block"></div> -->
  <div class="col-md-6">
    <h1>First Floor</h1>
    <div class="table-responsive" style="margin:20px">
      <table class="text-center" cellspacing="0">
        <tr>
          <td class="<?php echo $room[101]; ?>">101</td>
          <td class="<?php echo $room[102]; ?>">102</td>
          <td style="border:none"></td>
          <td class="<?php echo $room[103]; ?>">103</td>
          <td class="<?php echo $room[104]; ?>">104</td>
        </tr>
      </table>
    </div>
    <h1>Second Floor</h1>
    <div class="table-responsive" style="margin:20px">
      <table class="text-center" cellspacing="0">
        <tr>
          <td class="<?php echo $room[201]; ?>">201</td>
          <td class="<?php echo $room[202]; ?>">202</td>
          <td class="<?php echo $room[203]; ?>">203</td>
          <td class="<?php echo $room[204]; ?>">204</td>
          <td class="<?php echo $room[205]; ?>">205</td>
        </tr>
        <tr>
          <td style="border:none;height:50px"></td>
          <td style="border:none;height:50px"></td>
          <td style="border:none;height:50px"></td>
          <td style="border:none;height:50px"></td>
          <td style="border:none;height:50px"></td>
        </tr>
        <tr>
          <td class="<?php echo $room[206]; ?>">206</td>
          <td class="<?php echo $room[207]; ?>">207</td>
          <td class="<?php echo $room[208]; ?>">208</td>
          <td class="<?php echo $room[209]; ?>">209</td>
          <td class="<?php echo $room[210]; ?>">210</td>
        </tr>
      </table>
    </div>
  </div>
  <div class="col-md-6">
    <h1>Another Side</h1>
    <div class="table-responsive" style="margin:20px">
      <table class="text-center" cellspacing="0">
        <tr>
          <td class="<?php echo $room[105]; ?>">105</td>
          <td class="<?php echo $room[106]; ?>">106</td>
          <td class="<?php echo $room[107]; ?>">107</td>
          <td class="<?php echo $room[108]; ?>">108</td>
          <td style="border:none"></td>
          <td class="<?php echo $room[109]; ?>">109</td>
          <td class="<?php echo $room[110]; ?>">110</td>
          <td class="<?php echo $room[111]; ?>">111</td>
          <td class="<?php echo $room[112]; ?>">112</td>
        </tr>
      </table>
    </div>
  </div>
</main>
<?php require_once '../../footer.php';?>