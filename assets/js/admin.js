var Dashboard = function() {
  var menuChangeActive = function menuChangeActive(el) {
    if ($(el).hasClass("has-submenu")) {
      $('.c-menu__submenu.u-list').slideUp();
      if ($(el).find("ul").css("display") == "none") $(el).find("ul").slideDown();
      else if ($(el).find("ul").css("display") == "block") $(el).find("ul").slideUp();
    }
  };
  var sidebarChangeWidth = function sidebarChangeWidth() {
    var $menuItemsTitle = $("li .menu-item__title");
    $("body").toggleClass("sidebar-is-reduced sidebar-is-expanded");
    $(".hamburger-toggle").toggleClass("is-opened");
    if ($("body").hasClass("sidebar-is-expanded")) {
      setTimeout(function() {
        $('.logo__txt').hide();
        $('.logo__txt').html("Northwood Hotel");
        $('.logo__txt').fadeIn("slow");
      }, 400);
    } else {
      // $('.c-menu__submenu.u-list').slideUp();
      $('.logo__txt').hide();
      $('.logo__txt').html("NH");
      $('.logo__txt').fadeIn("slow");
    }
  };
  return {
    init: function init() {
      $(".js-hamburger").on("click", sidebarChangeWidth);
      $(".js-menu li").on("click", function(e) {
        menuChangeActive(e.currentTarget);
      });
    }
  };
}();
Dashboard.init();
$('input.datepicker').datepicker({
  format: "yyyy-mm-dd",
  autoclose: true,
  todayHighlight: true
});
$(window).on('resize', function() {
  $('.l-sidebar').height($(window).height() + 100);
});
// GIT UPDATE
$('#btnGitUpdate').click(function() {
  $.ajax({
    url: root + 'ajax/gitUpdate.php',
    success: function(response) {
      if (!response) {
        alertNotif("error", "Not Available for localhost");
      } else {
        alertNotif("success", response, false);
      }
    }
  });
})

function disableKey(evt, key) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (key == 'number') {
    if (charCode > 31 && (charCode > 48 || charCode < 57)) return false;
    return true;
  } else if (key == 'letter') {
    if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
    return true;
  } else {
    return true;
  }
}