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
    input = input.replace("shake", "");
  }
  if (input == "hayaanmosila") {
    socket.emit("playmusic", {
      url: "//" + location.hostname + root + "files/music/hayaanmosila.mp3",
      shake: shake
    })
  } else if (input == "harlem") {
    socket.emit("playmusic", {
      url: "//" + location.hostname + root + "files/music/harlemshake.mp3",
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
$("#btnRemoveBooking").click(function() {
  swal({
    title: 'Are you sure?',
    text: "You will remove all booking!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Refresh'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        context: this,
        type: 'POST',
        url: root + 'ajax/removeAllBooking.php',
        data: "&csrf_token=" + $("input[name=csrf_token]").val(),
        success: function(response) {
          if (response > 0) {
            swal({
              title: 'Removed Successfully!',
              text: "Number of removed booking: " + response,
              type: 'success'
            }).then((result) => {
              if (result.value) {
                location.reload();
              }
            });
          } else {
            swal({
              title: 'There was an error removing the booking!',
              text: "Number of removed booking: " + response,
              type: 'warning'
            });
          }
        }
      });
    }
  });
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
$("#btnBackupSql,#btnBackupExcel,#btnBackupAll").click(function() {
  var type = $(this).attr("id").replace("btnBackup", "").toLowerCase();
  var tables = [];
  $("select[name=cmbTablesToBackup] option:selected").each(function() {
    tables.push($(this).val());
  });
  if (tables.length > 0) {
    $.ajax({
      type: 'POST',
      url: root + "ajax/backupdb.php",
      data: {
        tables: tables,
        type: type,
        csrf_token: $("input[name=csrf_token]").val()
      },
      success: function(response) {
        if (response.includes("[" + tables.join("][") + "]")) {
          swal({
            title: 'Backup Successfully!',
            text: "Filename: " + response,
            type: 'success'
          })
        } else {
          swal({
            title: 'Backup Failed!',
            text: NOTHING_TO_BACKUP,
            type: 'warning'
          })
        }
      }
    });
  } else {
    alertNotif("error", "Select a table");
  }
});
$("#frmEditConfig").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnSave").html('<i class="fa fa-spinner fa-pulse"></i> Saving...');
  $(this).find('#btnSave').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $(this).find('input[type="checkbox"]').each(function() {
    if ($(this).prop("checked") != true) {
      $(this).prop("disabled", true);
    } else {
      $(this).parent().find("input[type=hidden]").prop("disabled", true);
    }
  })
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/editConfig.php',
    data: $(this).serialize(),
    success: function(response) {
      if (response == true) {
        $("#modalEditConfig").modal("hide");
        alertNotif("success", UPDATE_SUCCESS, true);
      } else {
        $(this).find("#btnSave").html('Save');
        $(this).find('#btnSave').attr('disabled', true);
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error editing the config file!</div>');
        });
      }
    }
  });
});