$(window).scroll(function() {
  if ($(this).scrollTop() < 400) {
    $("#arrowDown").fadeIn();
  } else {
    $("#arrowDown").fadeOut();
  }
});
$(window).on('load', function() {
  if ($("#modalPromo").length) {
    var options = {
      $AutoPlay: 3000,
      $PauseOnHover: 1,
      $FillMode: 1,
      $ArrowKeyNavigation: false,
      $SlideWidth: 400,
      $Cols: 2,
      $Align: 100,
      $DragOrientation: 1,
      $BulletNavigatorOptions: {
        $Class: $JssorBulletNavigator$
      }
    };
    var promo_slider = new $JssorSlider$('promo_slider_container', options);

    function PromoScaleSlider() {
      var parentElement = promo_slider.$Elmt.parentNode;
      var parentWidth = parentElement.clientWidth;
      if (parentWidth) {
        parentWidth = Math.min(parentWidth, 600);
        parentWidth = Math.max(parentWidth, 200);
        var clearFix = "both";
        var toClearElment = $Jssor$.$GetElement("clearFixDiv");
        toClearElment && $Jssor$.$Css(toClearElment, "clear", clearFix);
        promo_slider.$ScaleWidth(parentWidth);
      } else $Jssor$.$Delay(PromoScaleSlider, 30);
    }
    PromoScaleSlider();
    $(window).bind("load", PromoScaleSlider);
    $(window).bind("resize", PromoScaleSlider);
    $(window).bind("orientationchange", PromoScaleSlider);
  }
  if ($("#modalForgotToChangePassword").length) {
    $("#modalForgotToChangePassword").modal({
      backdrop: "static",
      keyboard: false
    });
    $("#modalForgotToChangePassword").modal('show');
  } else if ($("#tokenError").length) {
    alertNotif("error", $("#tokenError").html(), false);
  }
});
var home_transitions = [{
  $Duration: 800,
  $Opacity: 2
}];
var home_options = {
  $AutoPlay: true,
  $PauseOnHover: 1,
  $Idle: 3000,
  $ArrowKeyNavigation: false,
  $DragOrientation: 1,
  $PauseOnHover: 0,
  $ArrowNavigatorOptions: {
    $Class: $JssorArrowNavigator$
  },
  $SlideshowOptions: {
    $Class: $JssorSlideshowRunner$,
    $Transitions: home_transitions,
    $TransitionsOrder: 1
  },
};
var home_slider = new $JssorSlider$("home_slider", home_options);
home_slider.$Elmt.style.margin = "";
var MAX_WIDTH = 3000;
var MAX_HEIGHT = 3000;
var MAX_BLEEDING = 1;

function HomeScaleSlider() {
  var containerElement = home_slider.$Elmt.parentNode;
  var containerWidth = containerElement.clientWidth;
  if (containerWidth) {
    var originalWidth = home_slider.$OriginalWidth();
    var originalHeight = home_slider.$OriginalHeight();
    var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);
    var expectedHeight = Math.min(MAX_HEIGHT || originalHeight, originalHeight);
    if ($(window).width() < 480 || $(window).height() < 480) {
      home_slider.$ScaleSize(expectedWidth, expectedHeight - 80, MAX_BLEEDING);
    } else {
      home_slider.$ScaleSize(expectedWidth, expectedHeight, MAX_BLEEDING);
    }
    home_slider.$Elmt.style.top = ((originalHeight - expectedHeight) / 2) + "px";
    home_slider.$Elmt.style.left = ((containerWidth - expectedWidth) / 2) + "px";
  } else {
    window.setTimeout(ScaleSlider, 30);
  }
}
/*ios disable scrolling and bounce effect*/
//$Jssor$.$AddEvent(document, "touchmove", function(event){event.touches.length < 2 && $Jssor$.$CancelEvent(event);});
HomeScaleSlider();
$(window).bind("load", HomeScaleSlider);
$(window).bind("resize", HomeScaleSlider);
$(window).bind("orientationchange", HomeScaleSlider);
// });
// MORE INFO BUTTON
var jssor, temp;
$('.btnMoreInfo').click(function() {
  $("#modalRoom").find("#loadingMode").fadeIn();
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
      $("#modalRoom").find("div[data-u='slides']").html(response[0]);
      $("#modalRoom").find("#description").html(response[1]);
      var options = {
        $FillMode: 2,
        $ArrowKeyNavigation: false,
        $DragOrientation: 1, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)
        $ArrowNavigatorOptions: { //[Optional] Options to specify and enable arrow navigator or not
          $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
          $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
          $Steps: 1 //[Optional] Steps to go for each navigation request, default value is 1
        }
      };
      temp = $("#pictures").html();
      jssor = new $JssorSlider$('rooms_slider_container', options);
      $("#modalRoom").find("#loadingMode").fadeOut();
    }
  });
});
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
if ($("#feedbackForm").length) {
  var feedbackForm = $("#feedbackForm").html();
  $("#feedbackForm").remove();
  swal({
    title: "Please rate our service.",
    html: feedbackForm,
    allowOutsideClick: false,
    type: 'info',
    input: 'text',
    inputPlaceholder: 'Comments and Suggestions'
  }).then((result) => {
    $.ajax({
      type: 'POST',
      url: root + 'ajax/addFeedback.php',
      data: $("#frmFeedback").serialize() + "&txtComment=" + result.value,
      success: function(response) {
        swal({
          title: "Thanks for the feedback!",
          type: 'success'
        });
      }
    });
  });
}