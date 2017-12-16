<?php
require_once '../header.php';
require_once '../files/navbar.php';
?>
<div class="container-fluid">
  <div class="well center-block" style="width:90%;background:rgba(245,245,245,0.8)">
    <h1 style="text-align:center">Gallery</h1>
    <hr style="border-color:black"/>
    <ul class="nav nav-tabs nav-justified">
      <li class="active"><a data-toggle="tab" href="#room">Rooms</a></li>
      <li><a data-toggle="tab" href="#function">Function Hall</a></li>
      <li><a data-toggle="tab" href="#bigbite">BigBite</a></li>
      <li><a data-toggle="tab" href="#pool">Swimming Pool</a></li>
    </ul>
    <div class="tab-content">
      <div id="room" class="tab-pane fade in active">
        <div class="img-baguette">
<?php
foreach (glob("images/rooms/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
  $filename = str_replace("images/rooms/", "", $image);
  $caption  = str_replace([".jpg", ".bmp", ".jpeg", ".png"], "", $filename);
  echo "<a href='$image' data-caption='$caption'><img src='$image?v=" . filemtime("$image") . "' alt='$filename' class='zoom'></a>\n";
}
?>
        </div>
      </div>
      <div id="function" class="tab-pane fade">
        <div class="img-baguette">
          <?php
foreach (glob("images/function/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
  $filename = str_replace("images/function/", "", $image);
  echo "<a href='$image' data-caption='$filename'><img src='$image?v=" . filemtime("$image") . "' alt='$filename' class='zoom'></a>\n";
}
?>
        </div>
      </div>
      <div id="bigbite" class="tab-pane fade">
        <div class="img-baguette">
          <?php
foreach (glob("images/bigbite/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
  $filename = str_replace("images/bigbite/", "", $image);
  echo "<a href='$image' data-caption='$filename'><img src='$image?v=" . filemtime("$image") . "' alt='$filename' class='zoom'></a>\n";
}
?>
        </div>
      </div>
      <div id="pool" class="tab-pane fade">
        <div class="img-baguette">
          <?php
foreach (glob("images/pool/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
  $filename = str_replace("images/pool/", "", $image);
  echo "<a href='$image' data-caption='$filename'><img src='$image?v=" . filemtime("$image") . "' alt='$filename' class='zoom'></a>\n";
}
?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once '../footer.php';?>