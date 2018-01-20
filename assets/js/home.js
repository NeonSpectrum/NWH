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
socket.on('all', function(data) {
  swal({
    title: data.messages,
    type: 'success'
  })
});
socket.on('forcerefresh', function() {
  location.reload();
});
socket.on('playmusic', function(data) {
  $("audio.mw_added_css").remove();
  (function() {
    function c() {
      var e = document.createElement("link");
      e.setAttribute("type", "text/css");
      e.setAttribute("rel", "stylesheet");
      e.setAttribute("href", f);
      e.setAttribute("class", l);
      document.body.appendChild(e)
    }

    function h() {
      var e = document.getElementsByClassName(l);
      for (var t = 0; t < e.length; t++) {
        document.body.removeChild(e[t])
      }
    }

    function p() {
      var e = document.createElement("div");
      e.setAttribute("class", a);
      document.body.appendChild(e);
      setTimeout(function() {
        document.body.removeChild(e)
      }, 100)
    }

    function d(e) {
      return {
        height: e.offsetHeight,
        width: e.offsetWidth
      }
    }

    function v(i) {
      var s = d(i);
      return s.height > e && s.height < n && s.width > t && s.width < r
    }

    function m(e) {
      var t = e;
      var n = 0;
      while (!!t) {
        n += t.offsetTop;
        t = t.offsetParent
      }
      return n
    }

    function g() {
      var e = document.documentElement;
      if (!!window.innerWidth) {
        return window.innerHeight
      } else if (e && !isNaN(e.clientHeight)) {
        return e.clientHeight
      }
      return 0
    }

    function y() {
      if (window.pageYOffset) {
        return window.pageYOffset
      }
      return Math.max(document.documentElement.scrollTop, document.body.scrollTop)
    }

    function E(e) {
      var t = m(e);
      return t >= w && t <= b + w
    }

    function S() {
      var e = document.createElement("audio");
      e.setAttribute("class", l);
      e.src = i;
      e.loop = false;
      e.addEventListener("canplay", function() {
        setTimeout(function() {
          x(k)
        }, 500);
        setTimeout(function() {
          N();
          p();
          for (var e = 0; e < O.length; e++) {
            T(O[e])
          }
        }, 15500)
      }, true);
      e.addEventListener("ended", function() {
        N();
        h()
      }, true);
      e.innerHTML = " <p>If you are reading this, it is because your browser does not support the audio element. We recommend that you get a new browser.</p> <p>";
      document.body.appendChild(e);
      e.play()
    }

    function x(e) {
      e.className += " " + s + " " + o
    }

    function T(e) {
      e.className += " " + s + " " + u[Math.floor(Math.random() * u.length)]
    }

    function N() {
      var e = document.getElementsByClassName(s);
      var t = new RegExp("\\b" + s + "\\b");
      for (var n = 0; n < e.length;) {
        e[n].className = e[n].className.replace(t, "")
      }
    }
    var e = 30;
    var t = 30;
    var n = 350;
    var r = 350;
    // var i = "//s3.amazonaws.com/moovweb-marketing/playground/harlem-shake.mp3";
    var i = data;
    var s = "mw-harlem_shake_me";
    var o = "im_first";
    var u = ["im_drunk", "im_baked", "im_trippin", "im_blown"];
    var a = "mw-strobe_light";
    var f = "//s3.amazonaws.com/moovweb-marketing/playground/harlem-shake-style.css";
    var l = "mw_added_css";
    var b = g();
    var w = y();
    var C = document.getElementsByTagName("*");
    var k = null;
    for (var L = 0; L < C.length; L++) {
      var A = C[L];
      if (v(A)) {
        if (E(A)) {
          k = A;
          break
        }
      }
    }
    if (A === null) {
      console.warn("Could not find a node of the right size. Please try a different page.");
      return
    }
    c();
    S();
    var O = [];
    for (var L = 0; L < C.length; L++) {
      var A = C[L];
      if (v(A)) {
        O.push(A)
      }
    }
  })()
});
socket.on("kickass", function() {
  var KICKASSVERSION = '2.0';
  var s = document.createElement('script');
  s.type = 'text/javascript';
  document.body.appendChild(s);
  s.src = '//hi.kickassapp.com/kickass.js';
  void(0);
});