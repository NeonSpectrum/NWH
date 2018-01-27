<?php
require_once '../header.php';
require_once '../files/navbar.php';
?>
<div class="container-fluid">
  <div class="well center-block" style="width:90%;background:rgba(245,245,245,0.8)">
    <h1 style="text-align:center;font-weight:bold">Gallery</h1>
    <hr style="border-color:black"/>
    <ul class="nav nav-tabs nav-justified">
      <li class="active"><a data-toggle="tab" href="#rooms">Rooms</a></li>
      <li><a data-toggle="tab" href="#function">Function Hall</a></li>
      <li><a data-toggle="tab" href="#bigbite">BigBite</a></li>
      <li><a data-toggle="tab" href="#pool">Swimming Pool</a></li>
      <li><a data-toggle="tab" href="#events">Events</a></li>
    </ul>
    <div class="tab-content">
      <div id="rooms" class="tab-pane fade in active">
        <div class="img-baguette">
<?php
$view->gallery("rooms");
?>
        </div>
      </div>
      <div id="function" class="tab-pane fade">
        <div class="img-baguette">
<?php
$view->gallery("function");
?>
        </div>
      </div>
      <div id="bigbite" class="tab-pane fade">
        <div class="img-baguette">
<?php
$view->gallery("bigbite");
?>
        </div>
      </div>
      <div id="pool" class="tab-pane fade">
        <div class="img-baguette">
<?php
$view->gallery("pool");
?>
        </div>
      </div>
      <div id="events" class="tab-pane fade">
        <div class="img-baguette">
<?php
$view->gallery("events");
?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once '../footer.php';?>