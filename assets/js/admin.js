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
    url: currentDirectory + 'files/gitUpdate.php',
    success: function (response) {
      alert(response);
    }
  });
})

function alertNotif(type, message, reload, timeout) {
  $.notify(message, {
    autoHide: timeout == 0 ? false : true,
    autoHideDelay: timeout == null ? 3000 : timeout,
    className: type
  });
  setTimeout(function () {
    if (reload == null || !reload)
      return;
    else if (reload)
      location.reload();
    else
      location.href(reload);
  }, 2000);
}