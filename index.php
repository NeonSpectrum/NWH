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
<div style="position:relative;top:0;left:0;width:100%;height:100%;overflow:hidden;">
  <div id="home_slider" style="position:relative;margin:0 auto;top:0px;left:0px;width:960px;height:640px;overflow:hidden;visibility:hidden;">
      <!-- Loading Screen -->
    <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
        <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="<?php echo $root; ?>images/spin.svg" />
    </div>
    <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:960px;height:640px;overflow:hidden;">
<?php
// GET ALL FILES IN DIRECTORY images/carousel/ AND DISPLAY IT USING CAROUSEL
foreach (glob("images/carousel/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
  $filename = str_replace("images/carousel/", "", $image);
  echo "<div data-b='0' data-p='112.50' style='display: none;'>
          <img data-u='image' src='$image?v=" . filemtime("$image") . "' alt='$filename'>
        </div>\n";
}
?>
    <!-- <div id="progress-element" style="position: absolute; left: 0; bottom: 100px; width: 0%; height: 5px; background-color: rgba(255,255,255,0.9); z-index: 100;" data-u="progress"></div> -->
    </div>
    <!-- Arrow Navigator -->
    <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
        <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
            <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
        </svg>
    </div>
    <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
        <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
            <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
        </svg>
    </div>
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
    <figure class='imghvr-hinge-up' style='box-shadow: 1px 1px 1px #888888'>
      <img src='gallery/images/rooms/<?php echo "{$row['RoomType']}.jpg?v=" . filemtime("gallery/images/rooms/{$row['RoomType']}.jpg"); ?>'>
      <figcaption style='background: url("gallery/images/rooms/<?php echo "{$row['RoomType']}.jpg"; ?>") center;text-align:center;color:black;padding:0px'>
        <div style='background-color:rgba(255,255,255,0.8);position:relative;height:100%;width:100%;'>
          <div style='text-align:center;color:black;font-size:22px'><?php echo str_replace("_", " ", $row['RoomType']); ?><br/><div style="font-size:15px">Price starts at <i>₱ <?php echo number_format(getRoomPrice($row['RoomType'])); ?></i></div></div>
          <p style="padding:40px 20px"><?php echo $row['RoomDescription']; ?></p>
          <button id="<?php echo $row['RoomType']; ?>" class="btn btn-info btnMoreInfo" data-toggle="modal" data-target="#modalRoom" style="position:absolute;bottom:0;left:0;width:50%;text-decoration:underline">More Info</button>
          <button onclick="location.href='reservation'" class="btn btn-primary" style="position:absolute;bottom:0;right:0;width:50%;text-decoration:underline">Book Now</button>
        </div>
      </figcaption>
      <div style='text-align:center;color:black;font-size:22px'><?php echo str_replace("_", " ", $row['RoomType']); ?><br/><div style="font-size:15px">Price starts at <i>₱ <?php echo number_format(getRoomPrice($row['RoomType'])); ?></i></div></div>
    </figure>
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
<div id="modalRoom" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">
        <div class="row" style="margin:0">
          <div class="col-md-8" id="pictures">
            <div id="rooms_slider_container" style="position: relative; top: 0px; left: 0px; width: 550px;height: 400px;">
              <div data-u="slides" style="position: absolute; left: 0px; top: 0px; width: 550px; height: 400px;overflow: hidden;">

              </div>
              <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2"  data-scale-left="0.75">
                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                  <polyline class="a" points="11040,1920 4960,8000 11040,14080"></polyline>
                </svg>
              </div>
              <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale-right="0.75">
                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                  <polyline class="a" points="4960,1920 11040,8000 4960,14080"></polyline>
                </svg>
              </div>
            </div>
          </div>
          <div class="col-md-4" id="description" style="font-size:16px">

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
   </div>
</div>
<?php require_once 'footer.php';?>