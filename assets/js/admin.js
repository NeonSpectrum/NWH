setInterval("location.reload()", ADMIN_RELOAD_INTERVAL * 1000);
var date = new Date();
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
  endDate: "-" + (date.getFullYear() - parseInt(MAX_BIRTH_YEAR)) + "y"
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
$('input.datepicker,input.checkInDate, input.checkOutDate').keypress(function() {
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
  $.notify({
    icon: 'glyphicon glyphicon-bell',
    message: "<div style='text-align:center;margin-top:-20px'>" + data.user + "<br/>" + data.messages + "</div>"
  }, {
    type: "info",
    placement: {
      from: "bottom",
      align: "right"
    },
    mouse_over: true,
    delay: 10000
  });
});

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