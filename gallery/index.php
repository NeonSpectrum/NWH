<?php 
  require_once '../header.php';
  require_once '../files/navbar.php';
?>
<div class="container-fluid">
  <div class="well center-block" style="width:90%;background:rgba(245,245,245,0.8)">
    <h1>Gallery</h1>
    <hr style="border-color:black"/>
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
							$caption = str_replace([".jpg",".bmp",".jpeg",".png"],"",$filename);
							echo "<a href='$image' data-caption='$caption'><img src='$image?v=".filemtime("$image")."' alt='$filename' class='zoom'></a>\n";
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
  </div>
</div>
<?php require_once '../footer.php';?>