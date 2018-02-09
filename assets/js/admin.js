setInterval("location.reload()", ADMIN_RELOAD_INTERVAL * 1000);
var notificationTitle;
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
$('[data-tooltip="tooltip"]').tooltip({
  container: 'body'
});
$(".content-wrapper").click(function() {
  if ($("body").hasClass("sidebar-is-expanded")) {
    $(".hamburger-toggle").toggleClass("is-opened");
    $("body").removeClass("sidebar-is-expanded").addClass("sidebar-is-reduced");
    $('.logo__txt').hide();
    $('.logo__txt').html("NWH");
    $('.logo__txt').fadeIn("slow");
  }
});
$('input.birthDate').datepicker({
  format: DATE_FORMAT,
  autoclose: true,
  startView: 2,
  endDate: "-" + (moment(date).format("YYYY") - parseInt(MAX_BIRTH_YEAR)) + "y"
});
$("input.checkDate").each(function() {
  if (!$(this).val()) {
    $(this).daterangepicker({
      autoApply: true,
      minDate: moment(new Date()).add(0, 'days'),
      endDate: moment(new Date()).add(1, 'days'),
      locale: {
        format: DATE_FORMAT.toUpperCase()
      }
    });
  } else {
    $(this).daterangepicker({
      autoApply: true,
      minDate: moment(new Date()).add(0, 'days'),
      locale: {
        format: DATE_FORMAT.toUpperCase()
      }
    });
  }
});
$('input.datepicker, input.checkInDate, input.checkOutDate').keypress(function() {
  return false;
})
$("input.checkDate").on('apply.daterangepicker', function(ev, picker) {
  if (picker.startDate.format('MM/DD/YYYY') == picker.endDate.format('MM/DD/YYYY')) {
    var nextDay = moment(picker.startDate).add(1, 'days').format("MM/DD/YYYY");
    $(this).val(picker.startDate.format('MM/DD/YYYY') + " - " + nextDay);
    $(this).data('daterangepicker').setEndDate(nextDay);
  }
});
$(window).on('resize', function() {
  $('.l-sidebar').height($(window).height() + 100);
});
var tempCheckDate;
$('.modal').on('shown.bs.modal', function() {
  tempCheckDate = $(this).find("form").find("input.checkDate").val();
});
$('.modal').on('hidden.bs.modal', function() {
  $(this).find("form").trigger("reset");
  $(this).find("form").find("input.checkDate").val(tempCheckDate);
  $(this).find('.lblDisplayError').html('');
  $("#frmRegister").find('button[type=submit]').attr('disabled', true);
});
// GIT UPDATE
$('#btnGitUpdate').click(function() {
  $.ajax({
    type: 'POST',
    url: root + 'ajax/gitUpdate.php',
    success: function(response) {
      if (!response) {
        alertNotif("error", "Not Available for localhost");
      } else {
        alertNotif("success", response, false);
        if (response.includes("live.js")) {
          socket.emit("restart");
        }
      }
    }
  });
})
$('#btnLogout').click(function() {
  swal({
    title: 'Do you want to logout?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Logout'
  }).then((result) => {
    if (result.value) {
      location.href = "//" + location.hostname + root + "account/?mode=logout";
    }
  })
});
socket.on('notification', function(data) {
  var type = data.type == null ? "bell" : data.type;
  $(".drop-content").prepend("\
    <li style='position:relative' class='not-read'>\
      <div class='col-md-3 col-sm-3 col-xs-3' style='width:25%'><div class='notify-img'><i class='fa fa-" + type + "' style='font-size:4em'></i></div></div>\
      <div class='col-md-9 col-sm-9 col-xs-9 pd-l0 notify-message' style='width:75%'>" + data.messages + "</div><a id='" + data.id + "' class='rIcon' title='Mark As Read' data-tooltip='tooltip' data-placement='bottom'><i class='fa fa-dot-circle-o'></i></a>\
      <small style='position:absolute;bottom:0;right:0'>" + data.time + "</small>\
    </li>");
  $(".drop-content li:first").hide().fadeIn('slow');
  $(".c-badge--header-icon").hide().html(parseInt($(".c-badge--header-icon").html()) + 1);
  if (!$(".dropdown.c-header-icon.navbar-right").hasClass("open")) {
    $(".c-badge--header-icon").fadeIn();
  }
  $('[data-tooltip="tooltip"]').tooltip({
    container: 'body'
  });
  $('.drop-content').animate({
    scrollTop: 0
  }, 500);
  reinitializeButtonRIcon();
  var player = document.getElementById('sndNotification');
  player.pause();
  player.currentTime = 2;
  player.duration = 2;
  player.play();
  startBlinkTitle("New Notification");
});
socket.on('clickRead', function(data) {
  if ($(".rIcon#" + data).closest("li").hasClass("dropdown")) {
    $(".drop-content").fadeOut('fast', function() {
      $(".rIcon#" + data).html('');
      $(".c-badge--header-icon").html('0').hide();
    });
  } else {
    $(".rIcon#" + data).closest("li").removeClass("not-read");
    $(".c-badge--header-icon").html(parseInt($(".c-badge--header-icon").html()) - 1);
    if ($(".c-badge--header-icon").html() == 0) {
      $(".c-badge--header-icon").fadeOut();
    }
  }
});
$('.dropdown').on('show.bs.dropdown', function() {
  $(this).find('.dropdown-menu').first().stop(true, true).slideDown("fast");
  $(".c-badge").hide();
  stopBlinkTitle();
});
$('.dropdown').on('hide.bs.dropdown', function() {
  $(this).find('.dropdown-menu').first().stop(true, true).slideUp("fast");
  if ($(".c-badge").html() > 0) {
    $(".c-badge").fadeIn();
  }
});
$(".dropdown-menu.notify-drop").click(function(e) {
  e.stopPropagation();
});
reinitializeButtonRIcon();

function reinitializeButtonRIcon() {
  $(".rIcon").unbind("click");
  $(".rIcon").click(function() {
    $(this).fadeOut();
    var id = $(this).hasClass("allRead") ? "all" : $(this).attr("id");
    var message = $(this).parent().find(".notify-message").html();
    socket.emit("readNotif", {
      user: email_address,
      id: id,
      messages: message
    });
    if ($(this).hasClass("allRead")) {
      $(".rIcon:not('.allRead')").fadeOut();
      $(".drop-content").find("li").removeClass("not-read");
      $(".c-badge--header-icon").html('0').hide();
    } else {
      $(this).closest("li").removeClass("not-read");
      $(".c-badge--header-icon").html(parseInt($(".c-badge--header-icon").html()) - 1);
    }
  });
}

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

function startBlinkTitle(title) {
  if (!$(".dropdown.c-header-icon.navbar-right").hasClass("open")) {
    clearInterval(notificationTitle);
    notificationTitle = setInterval(function() {
      document.title = document.title == "Northwood Hotel" ? title : "Northwood Hotel";
    }, 1500)
  }
}

function stopBlinkTitle() {
  clearInterval(notificationTitle);
  document.title = "Northwood Hotel";
}