<?php
require_once 'header.php';
require_once 'files/navbar.php';
?>
<div style="position:relative;top:0;left:0;width:100%;height:100%;overflow:hidden;">
  <div style="position:relative">
    <div id="home_slider" style="position:relative;margin:0 auto;top:0px;left:0px;width:960px;height:640px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
      <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
        <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="<?php echo $root; ?>images/spin.svg" />
      </div>
      <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:960px;height:640px;overflow:hidden;">
<?php
$view->homeJssor();
?>
      <!-- <div id="progress-element" style="position: absolute; left: 0; bottom: 100px; width: 0%; height: 5px; background-color: rgba(255,255,255,0.9); z-index: 100;" data-u="progress"></div> -->
      </div>
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
    <div style="position:absolute;right:5px;bottom:10px;z-index:1" id="arrowDown">
      <a class="btn btn-default anchor-animate" href="#roomTypesArea" style="background:rgba(255,255,255,0.7);">
        <i class="fa fa-arrow-down" aria-hidden="true"></i>
      </a>
    </div>
  </div>
  <div class="booknow">
    <div class="booknow-content text-center center-block">
      <form class="form-inline frmBookCheck" method="post" action="reservation/">
        <div class="form-group">
          <label>Check Date: </label>
          <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            <input class="form-control checkDate" type="text" id="txtCheckDate" name="txtCheckDate" style="width:250px" readonly required/>
          </div>
        </div>
        <div class="form-group">
          <label>Adults: </label>
          <input class="form-control" type="number" id="txtAdults" name="txtAdults" size="20" value="1" onkeypress="return disableKey(event,'letter')" min="1" max="<?php echo MAX_ADULTS; ?>" required/>
        </div>
        <div class="form-group">
          <label>Children: </label>
          <input class="form-control" type="number" id="txtChildren" name="txtChildren" size="20" value="0" onkeypress="return disableKey(event,'letter')" min="0" max="<?php echo MAX_CHILDREN; ?>" required/>
        </div>
        <div class="form-group">
          <label></label>
          <button id="btnCheck" type="submit" class="btn btn-primary">Book Now</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="panel panel-default" style="border-top-width:0px;background: radial-gradient(ellipse at center, rgb(255, 255, 255) 60%, rgb(229, 229, 229) 100%);margin-bottom:0" id="roomTypesArea">
  <div class="panel-heading" style="background-color:inherit"><h1 style="text-align:center;font-weight:bold">ROOM TYPES</h1></div>
  <div class="panel-body center-block" style="width:90%">
    <div class="row">
<?php
if (!$db->connect_error) {
  $view->homeRooms();
}
?>
    </div>
  </div>
</div>
<div class="homeContent fixed-img">
  <div style="background: rgba(255, 255, 255, 0.3);height:100%;width:100%;">
    <div class="center-block" style="width:80%;margin-bottom:20px;padding-top:5px">
      <h1 class="wow slideInUp" style="color:#2389c9;padding:10px;text-align:center;text-shadow: 1px 1px #FFFFFF;background-color:rgba(255,255,255,0.7)">LUXURY MEETS AFFORDABILITY IN THE<br/>HEART OF ALAMINOS CITY</h1>
      <hr style="border-color:white;border-width:3px;width:10%"/>
      <div class="row center-block" style="background:rgba(255,255,255,0.7);padding-top:20px;overflow:hidden">
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
<div id="modalRoom" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">
        <div id="loadingMode" style="width:98%"></div>
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
<div id="modalPromo" class="modal animated zoomIn center" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <button type="button" class="close" style="position:absolute;top:5px;right:10px;font-size:30px;z-index:1;opacity:1" data-dismiss="modal">&times;</button>
      <div style="display: block; overflow: hidden; width: 100%; max-width:600px; min-width: 240px; font-size: .8em; line-height: 1.5em;">
        <div id="promo_slider_container" style="position: relative; float: left; top: 0px; left: 0px; width: 600px;height: 550px; overflow: hidden;">
          <div style="position: absolute; left: 0px; top: 0px; width: 600px; height: 550px;overflow: hidden;" u="slides">
<?php $view->promoPictures();?>
          </div>
          <div class="jssorb051" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75" data-u="navigator" style="position:absolute;bottom:7px;right:12px;z-index:2">
            <div class="i" data-u="prototype" style="width:16px;height:16px;">
              <svg style="position:absolute;top:0;left:0;width:100%;height:100%;" viewbox="0 0 16000 16000">
                <circle class="b" cx="8000" cy="8000" r="5800">
                </circle>
              </svg>
            </div>
          </div>
        </div>
      </div>
      <div id="background-bullet" style="background-color:rgba(0,0,0,0.4);position:absolute;bottom:0;left:0;width:100%;height:30px;z-index:1;overflow:hidden"></div>
    </div>
  </div>
</div>
<?php
if (isset($_GET['email']) && isset($_GET['token']) && $account->verifyForgotToken($_GET['email'], $_GET['token'])) {
  ?>
<div id="modalForgotToChangePassword" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center">Change Password</h4>
      </div>
      <form id="frmChange" method="post" class="form-horizontal">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
        <div class="modal-body">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" name="txtToken" value="<?php echo $_GET['token']; ?>"/>
          <div class="form-group">
            <label for="oldpass" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-8">
              <input name="txtEmail" type="text" class="form-control" id="txtEmail" value="<?php echo $_GET['email']; ?>" readonly/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">New Password</label>
            <div class="col-sm-8">
              <input name="txtNewPass" type="password" class="form-control" id="txtNewPass" placeholder="New Password" pattern="[\s\S]*\S[\s\S]*" minlength="8" required/>
              <input name="txtRetypeNewPass" type="password" style="margin-top:15px" class="form-control" id="txtRetypeNewPass" placeholder="Retype New Password" pattern="[\s\S]*\S[\s\S]*" minlength="8" required/>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="btnUpdate" type="submit" class="btn btn-info">Update</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
   </div>
</div>
<?php
} else if (isset($_GET['email']) && isset($_GET['token']) && !$account->verifyForgotToken($_GET['email'], $_GET['token'])) {
  ?>
<span id="tokenError"><?php echo TOKEN_EXPIRED; ?></span>
<?php
}
if ($account->checkFeedback()) {
  ?>
<div id="feedbackForm" style="display:none">
  <form id="frmFeedback">
    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"/>
    <div class='rate-area'>
      <input type='radio' id='5-star' name='rating' value='5' /><label for='5-star' title='Amazing'>5 stars</label>
      <input type='radio' id='4-star' name='rating' value='4' /><label for='4-star' title='Good'>4 stars</label>
      <input type='radio' id='3-star' name='rating' value='3' /><label for='3-star' title='Average'>3 stars</label>
      <input type='radio' id='2-star' name='rating' value='2' /><label for='2-star' title='Not Good'>2 stars</label>
      <input type='radio' id='1-star' name='rating' value='1' /><label for='1-star' title='Bad'>1 star</label>
    </div>
  </form>
</div>
<?php
}
require_once 'footer.php';
?>