setInterval(function() {
  Pace.ignore(function() {
    $.ajax({
      url: root + 'ajax/verifyLoginSession.php',
      success: function(response) {
        if (!response) {
          $.ajax({
            url: root + 'account?mode=logout',
            success: function() {
              alert("Your account has been logged in somewhere. Logging out...");
              location.reload(true);
            }
          });
        }
      }
    });
  });
}, 5000);