<?php
  session_start();
  require_once '../files/db.php';
  
  if (isset($_POST)) {
    $guests = (int)$_POST['txtAdults'];
    
    $query = "SELECT DISTINCT(RoomType), PeakRate, LeanRate, DiscountedRate FROM room_type JOIN room ON room_type.RoomTypeID = room.RoomTypeID WHERE Capacity >= $guests";
    $result = mysqli_query($db, $query);
    $x = 1;
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<div class='col-md-6'><input type='checkbox' id='cb".$x."' name='rdbRoom' value='{$row['RoomType']}'/>
      <label class='room-label' for='cb".$x++."'>";
      if (mktime(0, 0, 0, 10, 1, date('Y')) < mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y')) && mktime(11, 59, 59, 5, 31, date('Y') + 1) > mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y'))) {
        $price = $row['PeakRate'];
      } else if (mktime(0, 0, 0, 7, 1, date('Y')) < mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y')) && mktime(11, 59, 59, 8, 31, date('Y') + 1) > mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y'))) {
        $price = $row['LeanRate'];
      } else {
        $price = $row['DiscountedRate'];
      }
      echo "<figure class='imghvr-push-up' style='box-shadow: 1px 1px 1px #888888'>
              <img src='../gallery/images/rooms/{$row['RoomType']}.jpg'>
              <figcaption style='background-color:rgb(235,235,235);text-align:center;color:black;padding-top:0px'>
                  <h3 style='color:black'>".str_replace("_"," ",$row['RoomType'])."</h3><br/>
                  <p>₱&nbsp;".number_format($price)."</p>
              </figcaption>
            </figure>";
      echo "</label></div>";
    }
  }
?>