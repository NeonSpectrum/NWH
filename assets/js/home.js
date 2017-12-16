$(document).ready(function() {
  var home_transitions = [{
    $Duration: 400,
    $Delay: 40,
    $Cols: 16,
    $Formation: $JssorSlideshowFormations$.$FormationStraight,
    $Opacity: 2,
    $Assembly: 260
  }];
  var home_options = {
    $AutoPlay: true,
    $Idle: 3000,
    $DragOrientation: 1,
    $PauseOnHover: 0,
    $ArrowNavigatorOptions: {
      $Class: $JssorArrowNavigator$
    },
    $BulletNavigatorOptions: {
      $Class: $JssorBulletNavigator$
    },
    $SlideshowOptions: {
      $Class: $JssorSlideshowRunner$,
      $Transitions: home_transitions,
      $TransitionsOrder: 1
    },
  };
  var home_slider = new $JssorSlider$("home_slider", home_options);
  //make sure to clear margin of the slider container element
  home_slider.$Elmt.style.margin = "";
  /*#region responsive code begin*/
  /*
      parameters to scale jssor slider to fill a container

      MAX_WIDTH
          prevent slider from scaling too wide
      MAX_HEIGHT
          prevent slider from scaling too high, default value is original height
      MAX_BLEEDING
          prevent slider from bleeding outside too much, default value is 1
          0: contain mode, allow up to 0% to bleed outside, the slider will be all inside container
          1: cover mode, allow up to 100% to bleed outside, the slider will cover full area of container
          0.1: flex mode, allow up to 10% to bleed outside, this is better way to make full window slider, especially for mobile devices
  */
  var MAX_WIDTH = 3000;
  var MAX_HEIGHT = 3000;
  var MAX_BLEEDING = 1;

  function ScaleSlider() {
    var containerElement = home_slider.$Elmt.parentNode;
    var containerWidth = containerElement.clientWidth;
    if (containerWidth) {
      var originalWidth = home_slider.$OriginalWidth();
      var originalHeight = home_slider.$OriginalHeight();
      var containerHeight = containerElement.clientHeight || originalHeight;
      var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);
      var expectedHeight = Math.min(MAX_HEIGHT || containerHeight, containerHeight);
      //scale the slider to expected size
      home_slider.$ScaleSize(expectedWidth, expectedHeight, MAX_BLEEDING);
      //position slider at center in vertical orientation
      home_slider.$Elmt.style.top = ((containerHeight - expectedHeight) / 2) + "px";
      //position slider at center in horizontal orientation
      home_slider.$Elmt.style.left = ((containerWidth - expectedWidth) / 2) + "px";
    } else {
      window.setTimeout(ScaleSlider, 30);
    }
  }
  /*ios disable scrolling and bounce effect*/
  //$Jssor$.$AddEvent(document, "touchmove", function(event){event.touches.length < 2 && $Jssor$.$CancelEvent(event);});
  ScaleSlider();
  $(window).bind("load", ScaleSlider);
  $(window).bind("resize", ScaleSlider);
  $(window).bind("orientationchange", ScaleSlider);
  /*#endregion responsive code end*/
  // loading
  var progressElement = document.getElementById("progress-element");

  function ProgressChangeEventHandler(slideIndex, progress, progressBegin, idleBegin, idleEnd, progressEnd) {
    //this event continuously fires within the process of current slide
    //slideIndex: the index of slide
    //progress: current time in the whole process
    //progressBegin: the begining of the whole process (generally, layer animation starts to play in)
    //idleBegin: captions played in and become idle, will wait for a period which is specified by option '$Idle' (or a break point created using slider maker)
    //idleEnd: the idle time is over, play the rest until progressEnd
    //progressEnd: the whole process has been completed
    if (progressEnd > 0) {
      var progressPercent = progress / progressEnd * 100 + "%";
      progressElement.style.width = progressPercent;
    }
  }
  home_slider.$On($JssorSlider$.$EVT_PROGRESS_CHANGE, ProgressChangeEventHandler);
});
// MORE INFO BUTTON
var jssor, temp;
$('.btnMoreInfo').click(function() {
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/supplyMoreInfo.php',
    data: 'roomType=' + $(this).attr("id"),
    dataType: 'json',
    success: function(response) {
      if (jssor != null && temp != null) {
        jssor.$Pause();
        $("#rooms_slider_container").remove();
        $("#pictures").append(temp);
      }
      $("#modalRoom").find(".modal-title").html($(this).attr("id").replace("_", " "));
      $("#modalRoom").find("div[u='slides']").html(response[0]);
      $("#modalRoom").find("#description").html(response[1]);
      var options = {
        $FillMode: 2,
        $DragOrientation: 1, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)
        $ArrowNavigatorOptions: { //[Optional] Options to specify and enable arrow navigator or not
          $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
          $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
          $Steps: 1 //[Optional] Steps to go for each navigation request, default value is 1
        }
      };
      temp = $("#pictures").html();
      jssor = new $JssorSlider$('rooms_slider_container', options);
    }
  });
});
// YOUTUBE
(function() {
  var youtube = document.querySelectorAll(".youtube");
  for (var i = 0; i < youtube.length; i++) {
    var image = new Image();
    image.src = root + "images/nwh-sddefault.jpg";
    image.addEventListener("load", function() {
      youtube[i].appendChild(image);
    }(i));
    youtube[i].addEventListener("click", function() {
      var iframe = document.createElement("iframe");
      iframe.setAttribute("frameborder", "0");
      iframe.setAttribute("allowfullscreen", "");
      iframe.setAttribute("src", "https://www.youtube.com/embed/" + this.dataset.embed + "?rel=0&showinfo=0&autoplay=1");
      this.innerHTML = "";
      this.appendChild(iframe);
    });
  };
})();