<?php
require_once '../files/db.php';

if (isset($_POST)) {
  $guests = (int) $_POST['txtAdults'];

  $query  = "SELECT DISTINCT(RoomType), RoomDescription, PeakRate, LeanRate, DiscountedRate, COUNT(*) As NumberOfRooms FROM room_type JOIN room ON room_type.RoomTypeID = room.RoomTypeID WHERE Capacity >= 1 GROUP BY room_type.RoomTypeID";
  $result = mysqli_query($db, $query);

  echo "<div class='table-responsive'><table>";
  while ($row = mysqli_fetch_assoc($result)) {
    // echo "<div class='col-md-6'><input type='checkbox' id='cb" . $x . "' name='rdbRoom' value='{$row['RoomType']}'/>
    //   <label class='room-label' for='cb" . $x++ . "'>";
    // if (mktime(0, 0, 0, 10, 1, date('Y')) < mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y')) && mktime(11, 59, 59, 5, 31, date('Y') + 1) > mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y'))) {
    //   $price = $row['PeakRate'];
    // } else if (mktime(0, 0, 0, 7, 1, date('Y')) < mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y')) && mktime(11, 59, 59, 8, 31, date('Y') + 1) > mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y'))) {
    //   $price = $row['LeanRate'];
    // } else {
    //   $price = $row['DiscountedRate'];
    // }
    // echo "<figure class='imghvr-push-up' style='box-shadow: 1px 1px 1px #888888'>
    //           <img src='../gallery/images/rooms/{$row['RoomType']}.jpg'>
    //           <figcaption style='background-color:rgb(235,235,235);text-align:center;color:black;padding-top:0px'>
    //               <h3 style='color:black'>" . str_replace("_", " ", $row['RoomType']) . "</h3><br/>
    //               <p>₱&nbsp;" . number_format($price) . "</p>
    //           </figcaption>
    //         </figure>";
    // echo "</label></div>";

    echo "<tr>";
    echo "<td class='img-baguette' style='padding:10px'>";
    $first = true;
    foreach (glob("../gallery/images/rooms/{$row['RoomType']}*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
      $filename = str_replace("../gallery/images/rooms/", "", $image);
      $caption  = str_replace([".jpg", ".bmp", ".jpeg", ".png"], "", $filename);
      echo "<a href='$image' data-caption='$caption' style='";
      echo $first == true ? "" : "display:none";
      echo "'><img src='$image?v=" . filemtime("$image") . "' alt='$filename' height='200px'></a>\n";
      $first = false;
    }
    echo "</td>";
    echo "<td style='vertical-align:top;padding:10px'>
            <h3 id='roomName'>" . str_replace("_", " ", $row['RoomType']) . "</h3><br/>
            {$row['RoomDescription']}<br/><br/>
            <span style='text-style:bold;font-size:20px;'>Price: ₱&nbsp;<span id='roomPrice'>" . number_format(getRoomPrice($row['RoomType'])) . "</span></span>
          </td>";
    echo "<td style='padding:10px;width:100px' class='numberOfRooms'>";
    echo "<select style='width:100%' class='form-control'>";
    for ($i = 0; $i <= $row['NumberOfRooms']; $i++) {
      echo "<option>$i</option>";
    }
    echo "</select";
    echo "</td>";
    echo "</tr>";
  }
  echo "</div></table>";
}
?>