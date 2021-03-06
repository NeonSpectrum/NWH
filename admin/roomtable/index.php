<?php
require_once '../../header.php';
require_once '../../files/sidebar.php';

$roomID    = $roomDescription    = [];
$roomList  = $room->getRoomIDList();
$roomUsing = $room->getUsingRoomList();

foreach ($roomList as $value) {
  $row         = $db->query("SELECT * FROM room WHERE RoomID=$value")->fetch_assoc();
  $cleaning    = $row['Cleaning'];
  $maintenance = $row['Maintenance'];
  if (in_array($value, $roomUsing)) {
    $descriptions = $room->getRoomInfo($value);
    if (count($descriptions) == 0) {
      continue;
    }
    $roomDescription[$value] = "Booking ID: {$descriptions['bookingID']}<br/>Name: {$descriptions['name']}<br/>Email: {$descriptions['email']}<br/>Rooms: {$descriptions['rooms']} (" . (substr_count($descriptions['rooms'], ',') + 1) . ")<br/>Check In Date: {$descriptions['checkInDate']}<br/>Check Out Date: {$descriptions['checkOutDate']}";
    $roomID[$value]          = 'using';
  } else if ($cleaning) {
    $roomDescription[$value] = 'Click to clean';
    $roomID[$value]          = 'cleaning';
  } else if ($maintenance) {
    $roomDescription[$value] = '';
    $roomID[$value]          = 'maintenance';
  } else {
    $roomDescription[$value] = '';
    $roomID[$value]          = 'available';
  }
}
?>
<main class="l-main" style="position:relative">
  <div class="content-wrapper content-wrapper--with-bg" style="padding:0">
    <div style="position:absolute;bottom:0;right:5px">
      Available: <div style='display:inline-block;background-color:green;height:10px;width:10px'></div> |
      Occupied: <div style='display:inline-block;background-color:red;height:10px;width:10px'></div> |
      Dirty: <div style='display:inline-block;background-color:black;height:10px;width:10px'></div> |
      Maintenance: <div style='display:inline-block;background-color:gray;height:10px;width:10px'></div>
    </div>
    <div class="col-md-6" style="border-right:1px solid #102c58;height:100%">
      <h1 style="text-align:center">1<sup>st</sup> Building</h1>
      <h1>First Floor</h1>
      <div class="table-responsive">
        <table class="text-center" cellspacing="0">
          <tr>
            <td id="101" class="<?php echo $roomID[101]; ?>" title="<?php echo $roomDescription[101]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">101</td>
            <td id="102" class="<?php echo $roomID[102]; ?>" title="<?php echo $roomDescription[102]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">102</td>
            <td style="border:none"></td>
            <td id="103" class="<?php echo $roomID[103]; ?>" title="<?php echo $roomDescription[103]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">103</td>
          </tr>
        </table>
      </div>
      <h1>Second Floor</h1>
      <div class="table-responsive">
        <table class="text-center" cellspacing="0">
          <tr>
            <td id="201" class="<?php echo $roomID[201]; ?>" title="<?php echo $roomDescription[201]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">201</td>
            <td id="202" class="<?php echo $roomID[202]; ?>" title="<?php echo $roomDescription[202]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">202</td>
            <td id="203" class="<?php echo $roomID[203]; ?>" title="<?php echo $roomDescription[203]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">203</td>
            <td id="204" class="<?php echo $roomID[204]; ?>" title="<?php echo $roomDescription[204]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">204</td>
            <td id="205" class="<?php echo $roomID[205]; ?>" title="<?php echo $roomDescription[205]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">205</td>
            <td id="206" class="<?php echo $roomID[206]; ?>" title="<?php echo $roomDescription[206]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">206</td>
          </tr>
          <tr>
            <td style="border:none;height:50px"></td>
            <td style="border:none;height:50px"></td>
            <td style="border:none;height:50px"></td>
            <td style="border:none;height:50px"></td>
            <td style="border:none;height:50px"></td>
          </tr>
          <tr>
            <td id="207" class="<?php echo $roomID[207]; ?>" title="<?php echo $roomDescription[207]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">207</td>
            <td id="208" class="<?php echo $roomID[208]; ?>" title="<?php echo $roomDescription[208]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">208</td>
            <td id="209" class="<?php echo $roomID[209]; ?>" title="<?php echo $roomDescription[209]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">209</td>
            <td id="210" class="<?php echo $roomID[210]; ?>" title="<?php echo $roomDescription[210]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">210</td>
            <td id="211" class="<?php echo $roomID[211]; ?>" title="<?php echo $roomDescription[211]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">211</td>
            <td id="212" class="<?php echo $roomID[212]; ?>" title="<?php echo $roomDescription[212]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">212</td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-md-6" style="height:100%">
      <h1 style="text-align:center">2<sup>nd</sup> Building</h1>
      <h1>&nbsp;</h1>
      <div class="table-responsive">
        <table class="text-center" cellspacing="0">
          <tr>
            <td id="104" class="<?php echo $roomID[104]; ?>" title="<?php echo $roomDescription[104]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">104</td>
            <td id="105" class="<?php echo $roomID[105]; ?>" title="<?php echo $roomDescription[105]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">105</td>
            <td id="106" class="<?php echo $roomID[106]; ?>" title="<?php echo $roomDescription[106]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">106</td>
            <td id="107" class="<?php echo $roomID[107]; ?>" title="<?php echo $roomDescription[107]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">107</td>
            <td id="108" class="<?php echo $roomID[108]; ?>" title="<?php echo $roomDescription[108]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">108</td>
            <td style="border:none"></td>
            <td id="109" class="<?php echo $roomID[109]; ?>" title="<?php echo $roomDescription[109]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">109</td>
            <td id="110" class="<?php echo $roomID[110]; ?>" title="<?php echo $roomDescription[110]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">110</td>
            <td id="111" class="<?php echo $roomID[111]; ?>" title="<?php echo $roomDescription[111]; ?>" data-tooltip="tooltip" data-placement="right" data-html="true">111</td>
            <td id="112" class="<?php echo $roomID[112]; ?>" title="<?php echo $roomDescription[112]; ?>" data-tooltip="tooltip" data-placement="left" data-html="true">112</td>
            <td id="112" class="<?php echo $roomID[114]; ?>" title="<?php echo $roomDescription[114]; ?>" data-tooltip="tooltip" data-placement="left" data-html="true">114</td>
            <td id="112" class="<?php echo $roomID[115]; ?>" title="<?php echo $roomDescription[115]; ?>" data-tooltip="tooltip" data-placement="left" data-html="true">115</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</main>
<?php require_once '../../footer.php';?>
