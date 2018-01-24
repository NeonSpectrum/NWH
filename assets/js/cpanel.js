$("input[name=daterange]").daterangepicker({
  autoApply: true
});
$("#btnRevertCheckIn,#btnRevertCheckOut").click(function() {
  var type = $(this).attr("id") == "btnRevertCheckIn" ? "checkIn" : "checkOut";
  var bookingID = $(this).parent().find("#cmbBookingID").val();
  swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Revert'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        context: this,
        type: 'POST',
        url: root + 'ajax/revertCheck.php',
        data: "txtBookingID=" + bookingID + "&type=" + type + "&csrf_token=" + $("input[name=csrf_token]").val(),
        success: function(response) {
          if (response == true) {
            swal({
              title: 'Reverted Successfully!',
              text: "Booking ID: " + $(this).parent().find("#cmbBookingID option:selected").html(),
              type: 'success'
            }).then((result) => {
              if (result.value) {
                location.reload();
              }
            });
          } else {
            swal({
              title: 'You cannot revert it!',
              text: "Booking ID: " + $(this).parent().find("#cmbBookingID option:selected").html(),
              type: 'warning'
            });
          }
        }
      });
    }
  });
});
$("#frmGenerateReport").submit(function(e) {
  e.preventDefault();
  window.open("//" + location.hostname + root + "files/generateReport?daterange=" + $(this).find("input[name=daterange]").val().replace(" - ", "-"), '_blank', 'height=650,width=1000');
});
$("#frmSendToAllAdmin").submit(function(e) {
  e.preventDefault();
  socket.emit("all", {
    user: email_address,
    messages: $(this).find("input[name=txtMessage]").val()
  });
  $(this).trigger("reset");
});
$("#frmPlayMusic").submit(function(e) {
  e.preventDefault();
  var input = $(this).find("input[name=url]").val();
  var shake = false;
  if (input.slice(-5) == "shake") {
    shake = true;
    input.replace("shake", "");
  }
  if (input == "hayaanmosila") {
    socket.emit("playmusic", {
      url: "//" + location.hostname + root + "files/hayaanmosila.mp3",
      shake: shake
    })
  } else if (input == "harlemshake") {
    socket.emit("playmusic", {
      url: "//s3.amazonaws.com/moovweb-marketing/playground/harlem-shake.mp3",
      shake: shake
    });
  } else {
    socket.emit("playmusic", {
      url: input,
      shake: shake
    });
  }
  $(this).trigger("reset");
});
$("#btnKickAss").click(function() {
  socket.emit("kickass");
});
$("#btnForceRefresh").click(function() {
  swal({
    title: 'Are you sure?',
    text: "You will refresh the page of all users!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Refresh'
  }).then((result) => {
    if (result.value) {
      socket.emit("forcerefresh");
    }
  });
});