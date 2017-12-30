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
      $('.logo__txt').html("NWH");
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
$('input.checkDate').daterangepicker({
  autoApply: true,
  autoUpdateInput: true,
  locale: {
    format: DATE_FORMAT.toUpperCase()
  }
});
$('input.datepicker,input.checkInDate, input.checkOutDate').keypress(function() {
  return false;
})
$(window).on('resize', function() {
  $('.l-sidebar').height($(window).height() + 100);
});
$('.modal').on('hidden.bs.modal', function() {
  $(this).find("form").trigger("reset");
  $(this).find('.lblDisplayError').html('');
  $("#frmRegister").find('button[type=submit]').attr('disabled', true);
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