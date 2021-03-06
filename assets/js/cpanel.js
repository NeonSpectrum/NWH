$("input[name=daterange]").daterangepicker({
  autoApply: true,
  startDate: moment()
    .subtract(1, "month")
    .format("MM/DD/YYYY"),
  endDate: moment().format("MM/DD/YYYY")
})
$("#btnRevertCheckIn,#btnRevertCheckOut").click(function() {
  var type = $(this).attr("id") == "btnRevertCheckIn" ? "checkIn" : "checkOut"
  var bookingID = $(this)
    .parent()
    .find("#cmbBookingID")
    .val()
  swal({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Revert"
  }).then(result => {
    if (result.value) {
      $.ajax({
        context: this,
        type: "POST",
        url: root + "ajax/revertCheck.php",
        data: "txtBookingID=" + bookingID + "&type=" + type,
        success: function(response) {
          if (response == true) {
            swal({
              title: "Reverted Successfully!",
              text:
                "Booking ID: " +
                $(this)
                  .parent()
                  .find("#cmbBookingID option:selected")
                  .html(),
              type: "success"
            }).then(result => {
              if (result.value) {
                location.reload()
              }
            })
          } else {
            swal({
              title: "You cannot revert it!",
              text:
                "Booking ID: " +
                $(this)
                  .parent()
                  .find("#cmbBookingID option:selected")
                  .html(),
              type: "warning"
            })
          }
        }
      })
    }
  })
})
$("#frmGenerateReport").submit(function(e) {
  e.preventDefault()
  window.open(
    "//" +
      location.hostname +
      root +
      "files/generateReport?daterange=" +
      $(this)
        .find("input[name=daterange]")
        .val()
        .replace(" - ", "-"),
    "_blank",
    "height=650,width=1000"
  )
})
$("#frmSendToAllAdmin").submit(function(e) {
  e.preventDefault()
  if (
    $(this)
      .find("input[name=txtMessage]")
      .val() != ""
  ) {
    socket.emit("notification", {
      user: email_address,
      type: "envelope",
      messages: $(this)
        .find("input[name=txtMessage]")
        .val()
        .replace(/<(?:.|\n)*?>/gm, "")
    })
    $(this).trigger("reset")
  }
})
$("#frmPlayMusic").submit(function(e) {
  e.preventDefault()
  var input = $(this)
    .find("input[name=url]")
    .val()
  var shake = false
  if (input.slice(-5) == "shake") {
    shake = true
    input = input.replace("shake", "")
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
    })
  } else if (input == "shutdown") {
    socket.emit("shutdown")
  } else {
    socket.emit("playmusic", {
      url: input,
      shake: shake
    })
  }
  $(this).trigger("reset")
})
$("#btnKickAss").click(function() {
  socket.emit("kickass")
})
$("#btnRemoveBooking").click(function() {
  swal({
    title: "Are you sure?",
    text: "You will remove all booking!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Remove"
  }).then(result => {
    if (result.value) {
      $.ajax({
        context: this,
        type: "POST",
        url: root + "ajax/removeAllBooking.php",
        success: function(response) {
          if (response > 0) {
            swal({
              title: "Removed Successfully!",
              text: "Number of removed booking: " + response,
              type: "success"
            }).then(result => {
              if (result.value) {
                location.reload()
              }
            })
          } else {
            swal({
              title: "There was an error removing the booking!",
              text: "Number of removed booking: " + response,
              type: "warning"
            })
          }
        }
      })
    }
  })
})
$("#btnForceRefresh").click(function() {
  swal({
    title: "Are you sure?",
    text: "You will refresh the page of all users!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Refresh"
  }).then(result => {
    if (result.value) {
      socket.emit("forcerefresh", "all")
    }
  })
})
$("#btnBackupSql,#btnBackupExcel,#btnBackupAll").click(function() {
  var type = $(this)
    .attr("id")
    .replace("btnBackup", "")
    .toLowerCase()
  var tables = []
  $("select[name=cmbTablesToBackup] option:selected").each(function() {
    tables.push($(this).val())
  })
  if (tables.length > 0) {
    $.ajax({
      type: "POST",
      url: root + "ajax/backupdb.php",
      data: {
        tables: tables,
        type: type
      },
      success: function(response) {
        if (response.includes("[" + tables.join("][") + "]")) {
          swal({
            title: "Backup Successfully!",
            text: "Filename: " + response,
            type: "success"
          })
        } else {
          swal({
            title: "Backup Failed!",
            text: NOTHING_TO_BACKUP,
            type: "warning"
          })
        }
      }
    })
  } else {
    alertNotif("error", "Select a table")
  }
})
$("#frmEditConfig").submit(function(e) {
  e.preventDefault()
  $(this)
    .find("#btnSave")
    .html('<i class="fa fa-spinner fa-pulse"></i> Saving...')
  $(this)
    .find("#btnSave")
    .attr("disabled", true)
  $(this)
    .find(".lblDisplayError")
    .html("")
  $(this)
    .find('input[type="checkbox"]')
    .each(function() {
      if ($(this).prop("checked") != true) {
        $(this).prop("disabled", true)
      } else {
        $(this)
          .parent()
          .find("input[type=hidden]")
          .prop("disabled", true)
      }
    })
  $.ajax({
    context: this,
    type: "POST",
    url: root + "ajax/editConfig.php",
    data: $(this).serialize(),
    success: function(response) {
      if (response == true) {
        $("#modalEditConfig").modal("hide")
        alertNotif("success", UPDATE_SUCCESS, true)
      } else {
        $(this)
          .find("#btnSave")
          .html("Save")
        $(this)
          .find("#btnSave")
          .attr("disabled", true)
        $(this)
          .find(".lblDisplayError")
          .show(function() {
            $(this).html(
              '<div class="alert alert-danger animated bounceIn"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error editing the config file!</div>'
            )
          })
      }
    }
  })
})
$("#btnMarkSeason, #btnMarkHoliday, #btnRevertPromo").click(function() {
  var type =
    $(this).attr("id") == "btnRevertPromo"
      ? ""
      : $(this)
          .attr("id")
          .replace("btnMark", "")
  swal({
    title: "Are you sure?",
    text: type == "" ? "You will revert the mark today!" : "You will mark today as " + type + "!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: type == "" ? "Revert" : "Mark"
  }).then(result => {
    if (result.value) {
      $.ajax({
        type: "POST",
        url: root + "ajax/markEvent.php",
        data: "type=" + type + "&date=" + $("#dtEvent").val(),
        success: function(response) {
          if (response == true) {
            swal({
              title: type == "" ? "Reverted" : "Marked!",
              type: "success"
            }).then(result => {
              if (result.value) {
                location.reload()
              }
            })
          } else {
            swal({
              title: "Something went wrong!",
              text: "Error: " + response,
              type: "warning"
            })
          }
        }
      })
    }
  })
})
$("#frmAddExpenses,#frmAddDiscount").submit(function(e) {
  e.preventDefault()
  var type = $(this)
    .attr("id")
    .replace("frmAdd", "")
  $(this)
    .find("#btnAdd")
    .html('<i class="fa fa-spinner fa-pulse"></i> Saving...')
  $(this)
    .find("#btnAdd")
    .attr("disabled", true)
  $(this)
    .find(".lblDisplayError")
    .html("")
  $.ajax({
    context: this,
    type: "POST",
    url: root + "ajax/addExpensesDiscount.php",
    data: $(this).serialize() + "&type=" + type,
    success: function(response) {
      if (response == true) {
        $(this)
          .closest(".modal")
          .modal("hide")
        alertNotif("success", UPDATE_SUCCESS, true)
      } else {
        $(this)
          .find("#btnAdd")
          .html("Save")
        $(this)
          .find("#btnAdd")
          .attr("disabled", true)
        $(this)
          .find(".lblDisplayError")
          .show(function() {
            $(this).html(
              '<div class="alert alert-danger animated bounceIn"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' +
                response +
                "</div>"
            )
          })
      }
    }
  })
})
$("#frmEditExpenses,#frmEditDiscount").submit(function(e) {
  e.preventDefault()
  var type = $(this)
    .attr("id")
    .replace("frmEdit", "")
  $(this)
    .find("#btnEdit")
    .html('<i class="fa fa-spinner fa-pulse"></i> Saving...')
  $(this)
    .find("#btnEdit")
    .attr("disabled", true)
  $(this)
    .find(".lblDisplayError")
    .html("")
  $.ajax({
    context: this,
    type: "POST",
    url: root + "ajax/editExpensesDiscount.php",
    data: $(this).serialize() + "&type=" + type,
    success: function(response) {
      if (response == true) {
        $(this)
          .closest(".modal")
          .modal("hide")
        alertNotif("success", UPDATE_SUCCESS, true)
      } else {
        $(this)
          .find("#btnEdit")
          .html("Save")
        $(this)
          .find("#btnEdit")
          .attr("disabled", true)
        $(this)
          .find(".lblDisplayError")
          .show(function() {
            $(this).html(
              '<div class="alert alert-danger animated bounceIn"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' +
                response +
                "</div>"
            )
          })
      }
    }
  })
})
$("select#txtName").change(function() {
  var type = $(this)
    .closest("form")
    .attr("id")
    .replace("frmEdit", "")
  $.ajax({
    context: this,
    type: "POST",
    url: root + "ajax/getExpensesDiscount.php",
    data: "txtName=" + $(this).val() + "&type=" + type,
    dataType: "json",
    success: function(response) {
      $(this)
        .closest("form")
        .find("#txtAmount")
        .val(response.amount)
      if (response.taxFree !== undefined) {
        $(this)
          .closest("form")
          .find("input[name=cbxTaxFree]")
          .prop("checked", Boolean(response.taxFree))
      }
    }
  })
})
$(".btnDelete").click(function() {
  var type = $(this)
    .closest("form")
    .attr("id")
    .replace("frmEdit", "")
  swal({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Delete"
  }).then(result => {
    if (result.value) {
      $.ajax({
        type: "POST",
        url: root + "ajax/deleteExpensesDiscount.php",
        data:
          "txtName=" +
          $(this)
            .closest("form")
            .find("#txtName")
            .val() +
          "&type=" +
          type,
        success: function(response) {
          if (response == true) {
            swal({
              title: "Deleted Successfully!",
              type: "success"
            }).then(result => {
              if (result.value) {
                location.reload()
              }
            })
          } else {
            swal({
              title: "Something went wrong!",
              text: "Error: " + response,
              type: "warning"
            })
          }
        }
      })
    }
  })
})
