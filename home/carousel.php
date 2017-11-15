<div class="overlay">
  <div class="logo-overlay">
    <div class="logo-text">
      <div class="full-screen">
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
          <div class="carousel-inner" role="listbox">
            <?php
              foreach (glob("images/carousel/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image)
              {
                $filename = str_replace("images/carousel/","",$image);
                echo "<div class='item'><img src='$image?v=".filemtime("$image")."' alt='$filename'></div>\n";
              }
            ?>
          </div>
          <a class="left carousel-control" href="javascript:void(0)" role="button" onclick="$('#carousel').carousel('prev')" style="background:transparent !important">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="javascript:void(0)" role="button" onclick="$('#carousel').carousel('next')" style="background:transparent !important">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>