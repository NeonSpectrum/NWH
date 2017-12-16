<?php
require_once '../header.php';
require_once '../files/navbar.php';
?>
<div class="container-fluid">
  <div class="well center-block" style="width:90%;background:rgba(255,255,255,0.9)">
    <h1 style="text-align:center">Room and Rates</h1>
    <hr style="border-color:black"/>
    <div class="table-responsive">
      <table>
<?php
$query  = "SELECT * FROM room_type";
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td class='img-baguette'>";
  // echo "<a href='../gallery/images/rooms/{$row['RoomType']}.jpg' data-caption='" . str_replace("_", " ", $row['RoomType']) . "'>
  //         <img src='../gallery/images/rooms/{$row['RoomType']}.jpg' height='200px'/>
  //       </a>";
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
  echo "<td style='vertical-align:top'>
          <h3>" . str_replace("_", " ", $row['RoomType']) . "</h3><br/>
          {$row['RoomDescription']}
        </td>";
  echo "<td><center>From<br/><br/><span style='text-style:bold;font-size:20px;'>₱&nbsp;" . number_format(getRoomPrice($row['RoomType'])) . "</span></center></td>";
  echo "</tr>";
}
?>
      </table>
    </div>
  </div>
</div>
<?php require_once '../footer.php';?>