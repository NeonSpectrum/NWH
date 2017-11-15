<?php require_once $root.'../files/db.php';?>
<?php
  // $query = "select * from gallery where category='function'";
  // $result = mysqli_query($db, $query);
  // while ($row = mysqli_fetch_assoc($result))
  // {
  // 	echo "<a href='images/{$row['Category']}/{$row['Source']}' data-caption='{$row['Name']}'><img src='images/{$row['Category']}/{$row['Source']}' class='zoom' alt='{$row['Name']}'/></a>\n";
  // }
?>
<div class="galleryDiv">
  <div class="tab">
    <button class="tablinks active" onclick="openTab(event, 'room')">Rooms</button>
    <button class="tablinks" onclick="openTab(event, 'function')">Function Hall</button>
    <button class="tablinks" onclick="openTab(event, 'bigbite')">BigBite</button>
    <button class="tablinks" onclick="openTab(event, 'pool')">Swimming Pool</button>
  </div>

  <div id="room" class="tabcontent" style="display:block">
    <div class="galleryContent">
      <?php
        foreach (glob("images/rooms/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image)
        {
          $filename = str_replace("images/rooms/","",$image);
          echo "<a href='$image' data-caption='$filename'><img src='$image?v=".filemtime("$image")."' alt='$filename' class='zoom'></a>\n";
        }
      ?>
    </div>
  </div>

  <div id="function" class="tabcontent">
    <div class="galleryContent">
      <?php
        foreach (glob("images/function/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image)
        {
          $filename = str_replace("images/function/","",$image);
          echo "<a href='$image' data-caption='$filename'><img src='$image?v=".filemtime("$image")."' alt='$filename' class='zoom'></a>\n";
        }
      ?>
    </div>
  </div>

  <div id="bigbite" class="tabcontent">
    <div class="galleryContent">
      <?php
        foreach (glob("images/bigbite/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image)
        {
          $filename = str_replace("images/bigbite/","",$image);
          echo "<a href='$image' data-caption='$filename'><img src='$image?v=".filemtime("$image")."' alt='$filename' class='zoom'></a>\n";
        }
      ?>
    </div>
  </div>

  <div id="pool" class="tabcontent">
    <div class="galleryContent">
      <?php
        foreach (glob("images/pool/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image)
        {
          $filename = str_replace("images/pool/","",$image);
          echo "<a href='$image' data-caption='$filename'><img src='$image?v=".filemtime("$image")."' alt='$filename' class='zoom'></a>\n";
        }
      ?>
    </div>
  </div>
</div>