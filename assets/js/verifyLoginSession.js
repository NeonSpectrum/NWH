setInterval(function() {
  Pace.ignore(function() {
    $.ajax({
      url: root + 'ajax/verifyLoginSession.php',
      success: function(response) {
        console.log(response);
        if (!response) {
          $.ajax({
            url: root + 'account?mode=logout',
            success: function() {
              location.reload(true);
            }
          });
          alert("Your account has been logged in somewhere. Logging out...");
        }
      }
    });
  });
}, 5000);