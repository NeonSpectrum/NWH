<?php
// if (!isset($_COOKIE['firstvisit']))
// {
//   setcookie("firstvisit", true, time() + 60 * 3);
//   header('Location: welcome');
//   exit();
// }
// error_reporting(-1); // reports all errors
// ini_set("display_errors", "1"); // shows all errors
// ini_set("log_errors", 1);
require_once 'header.php';
require_once 'files/navbar.php';
?>
<div class="full-screen">
  <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
    <div class="carousel-inner" role="listbox">
<?php
// GET ALL FILES IN DIRECTORY images/carousel/ AND DISPLAY IT USING CAROUSEL
foreach (glob("images/carousel/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
  $filename = str_replace("images/carousel/", "", $image);
  echo "      <div class='item'><img src='$image?v=".filemtime("$image")."' alt='$filename'></div>\n";
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
    <form class="form-inline frmBookCheck">
      <div class="form-group">
        <label>Check In Date: </label>
        <div class="input-group">
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
          <input class="form-control checkInDate" type="text" id="txtCheckInDate" name="txtCheckInDate" required readonly/>
        </div>
      </div>
      <div class="form-group">
        <label>Check Out Date: </label>
        <div class="input-group">
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
          <input class="form-control checkOutDate" type="text" id="txtCheckOutDate" name="txtCheckOutDate" required readonly/>
        </div>
      </div>
      <div class="form-group">
        <label>Adults: </label>
        <input class="form-control" type="number" id="txtAdults" name="txtAdults" value="1" onkeypress="return disableKey(event,'letter')" min="1" max="10" required/>
      </div>
      <div class="form-group">
        <label>Children: </label>
        <input class="form-control" type="number" id="txtChildren" name="txtChildren" value="0" onkeypress="return disableKey(event,'letter')" min="0" max="10" required/>
      </div>
      <div class="form-group">
        <label></label>
        <button id="btnCheck" type="submit" class="btn btn-primary" <?php echo !isset($_SESSION['email']) ? 'disabled' : ''; ?>><?php echo !isset($_SESSION['email']) ? 'Login First!' : 'Book Now'; ?></button>
      </div>
    </form>
  </div>
</div>
<div class="panel panel-default" style="border-top-width:0px;">
  <div class="panel-heading" style="background-color:inherit"><h1 style="text-align:center">ROOM TYPES</h1></div>
  <div class="panel-body center-block" style="width:80%">
    <div class="row">
<?php
// USE DATABASE TO SUPPLY ROOM INFORMATION
$query  = "SELECT * FROM room_type";
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($result)) {
  ?>
  <div class='col-sm-4 wow slideInUp' style='margin-bottom:20px'>
    <figure class='imghvr-fade' style='box-shadow: 1px 1px 1px #888888'>
      <img src='gallery/images/rooms/<?php echo "{$row['RoomType']}.jpg?v=".filemtime("gallery/images/rooms/{$row['RoomType']}.jpg"); ?>'>
      <figcaption style='background: url("gallery/images/rooms/<?php echo "{$row['RoomType']}.jpg"; ?>") center;text-align:center;color:black;padding:0px'>
        <div style='background-color:rgba(255,255,255,0.8);height:100%;width:100%;position:fixed;padding:40px 20px'>
          <p><?php echo $row['RoomDescription']; ?></p>
        </div>
      </figcaption>
    </figure>
    <h3 style='text-align:center'><?php echo str_replace("_", " ", $row['RoomType']); ?></h3>
  </div>
<?php
}
?>
      </div>
    </div>
  </div>
</div>
<div class="homeContent fixed-img">
  <div style="background: rgba(255, 255, 255, 0.3);height:100%;width:100%;">
    <div class="center-block" style="width:80%;margin-bottom:20px;padding-top:5px">
      <h1 class="wow slideInUp" style="color:#2389c9;padding:10px;text-align:center;text-shadow: 1px 1px #FFFFFF">LUXURY MEETS AFFORDABILITY IN THE<br/>HEART OF ALAMINOS CITY</h1>
      <hr style="border-color:white;border-width:3px;width:10%"/>
      <div class="row center-block" style="background:rgba(255,255,255,0.6);padding-top:20px;overflow:hidden">
        <div class="col-md-6 wow slideInLeft">
          <p style="font-style:italic;font-size:20px;padding:0px 30px 0px 30px;">One of the most exciting and amazing tourist destination in the Philippines, The Hundred Islands National Park in Alaminos, Pangasinan that covers 123 islands with 1,844 hectares. Northwood Hotel is just a few minutes away from Don Gonzalo Montemayor wharf in Barangay Lucap where you can rent a boat and start exploring the beautiful paradise of Governor’s Island, Quezon Island, Marcos Island, Children Island and some other islets.</p>
        </div>
        <div class="col-md-6 wow slideInRight">
          <div class="youtube" data-embed="izqnhjcyP0E">
            <div class="play-button"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once 'footer.php';?>