var root = location.pathname.includes("nwh") ? "/nwh/" : "/";

$(document).ready(function () {
  var trigger = $('.hamburger'),
    overlay = $('.overlay'),
    isClosed = false;

  trigger.click(function () {
    hamburger_cross();
  });

  function hamburger_cross() {
    if (isClosed == true) {
      overlay.hide();
      trigger.removeClass('is-open');
      trigger.addClass('is-closed');
      isClosed = false;
    } else {
      overlay.show();
      trigger.removeClass('is-closed');
      trigger.addClass('is-open');
      isClosed = true;
    }
  }

  $('[data-toggle="offcanvas"]').click(function () {
    $('#wrapper').toggleClass('toggled');
  });
});

// GIT UPDATE
$('#btnGitUpdate').click(function () {
  $.ajax({
    url: root + 'files/gitUpdate.php',
    success: function (response) {
      alertNotif("success", response, true, 10000);
    }
  });
})

function alertNotif(type, message, reload, timeout) {
  console.log(message.length / 50 * 1000);
  $.notify({
    icon: "glyphicon glyphicon-exclamation-sign",
    message: "<div style='text-align:center;margin-top:-20px'>" + message + "</div>"
  }, {
    type: type == 'error' ? 'danger' : type,
    placement: {
      from: "top",
      align: "center"
    },
    newest_on_top: true,
    mouse_over: true,
    delay: message.length > 100 ? 0 : 3000
  });
  setTimeout(function () {
    if (reload == null || !reload)
      return;
    else if (reload)
      location.reload();
    else
      location.href(reload);
  }, timeout != null ? timeout : 2000);
}