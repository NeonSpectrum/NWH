<?php
  require_once 'header.php';
  require_once 'files/navbar.php';
?>
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
<div class="booknow center-block">
  <div class="booknow-content text-center">
    <form id="frmBookCheck" class="form-inline">
        <div class="form-group">
          <label>Check In Date: </label>
          <input class="form-control checkInDate" type="date" id="txtCheckInDate" name="txtCheckInDate" onkeypress="return disableKey(event,'number')" required/>
        </div>
        <div class="form-group">
          <label>Check Out Date: </label>
          <input class="form-control checkOutDate" type="date" id="txtCheckOutDate" name="txtCheckOutDate" onkeypress="return disableKey(event,'number')" required/>
        </div>
        <div class="form-group">
          <label>Adults: </label>
          <input class="form-control" type="number" id="txtAdults" name="txtAdults" value="0" onkeypress="return disableKey(event,'letter')" min="0" max="10" required/>
        </div>
        <div class="form-group">
          <label>Children: </label>
          <input class="form-control" type="number" id="txtChildren" name="txtChildren" value="0" onkeypress="return disableKey(event,'letter')" min="0" max="10" required/>
        </div>
        <div class="form-group">
          <label></label>
          <button class="btn btn-primary" id="btnCheck">Book Now</button>
        </div>
    </form>
  </div>
</div>
<div class="panel panel-default" style="border-top-width:0px;">
  <div class="panel-heading" style="background-color:inherit"><h1 style="text-align:center">ROOM TYPES</h1></div>
  <div class="panel-body center-block" style="width:80%">
    <div class="row">
      <?php
        $query = "SELECT * FROM room_type";
        $result = mysqli_query($db, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<div class='col-sm-4 animated scrollSlideUp' style='margin-bottom:20px'>";
          echo "<figure class='imghvr-push-up' style='box-shadow: 1px 1px 1px #888888'>
                  <img src='gallery/images/rooms/{$row['RoomType']}.jpg'>
                  <figcaption style='background-color:rgb(235,235,235);text-align:center;color:black;padding-top:0px'>
                      <h3 style='color:black'>".str_replace("_"," ",$row['RoomType'])."</h3><br/>
                      <p>{$row['RoomDescription']}</p>
                  </figcaption>
                </figure>";
          echo "</div>";
        }
      ?>
      </div>
    </div>
  </div>
</div>
<div class="homeContent fixed-img">
  <div style="background: rgba(255, 255, 255, 0.3);height:100%;width:100%;">
    <div class="center-block" style="width:80%;margin-bottom:20px;padding-top:5px">
      <h1 class="animated scrollSlideUp" style="color:#2389c9;padding:10px;text-align:center;text-shadow: 1px 1px #FFFFFF">LUXURY MEETS AFFORDABILITY IN THE<br/>HEART OF ALAMINOS CITY</h1>
      <hr style="border-color:white;border-width:3px;width:10%"/>
      <div class="row center-block" style="background:rgba(255,255,255,0.6);padding-top:20px;overflow:hidden">
        <div class="col-md-6 animated scrollSlideLeft">
          <p style="font-style:italic;font-size:20px;padding:0px 30px 0px 30px;">One of the most exciting and amazing tourist destination in the Philippines, The Hundred Islands National Park in Alaminos, Pangasinan that covers 123 islands with 1,844 hectares. Northwood Hotel is just a few minutes away from Don Gonzalo Montemayor wharf in Barangay Lucap where you can rent a boat and start exploring the beautiful paradise of Governor’s Island, Quezon Island, Marcos Island, Children Island and some other islets.</p>
        </div>
        <div class="col-md-6 animated scrollSlideRight">
          <div class="youtube" data-embed="izqnhjcyP0E"> 
            <div class="play-button"></div> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once 'footer.php';?>