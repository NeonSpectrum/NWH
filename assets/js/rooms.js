$('.cbxRoom').change(function() {
  var status = $(this).prop('checked') ? "1" : "0";
  $.ajax({
    type: 'POST',
    url: root + 'ajax/changeRoomStatus.php',
    data: 'roomID=' + $(this).attr("id") + "&status=" + status + "&csrf_token=" + $("input[name=csrf_token]").val()
  });
});
$('.btnEditRoomID').click(function() {
  var roomID = $(this).attr("id");
  var roomType = $(this).parent().parent().find("#txtRoomType").html().replace(" ", "_");
  $("#modalEditRoomID").find('.modal-title').html("Room ID: " + roomID);
  $("#modalEditRoomID").find("#cmbRoomType").val(roomType);
});
$('.btnEditRoomType').click(function() {
  var roomType = $(this).attr("id").replace("_", " ");
  var roomDescription = $(this).parent().parent().find("#txtRoomDescription").html().replace(/<br>/g, "");
  var roomSimpDesc = $(this).parent().parent().find("#txtRoomSimpDesc").html().split("<br>").join("");
  var icon = $(this).parent().parent().find("#txtIcon").html().split("<br>").join("");
  var capacity = $(this).parent().parent().find("#txtCapacity").html();
  var regularRate = $(this).parent().parent().find("#txtRegularRate").html().replace("₱&nbsp;", "").replace(",", "");
  var seasonRate = $(this).parent().parent().find("#txtSeasonRate").html().replace("₱&nbsp;", "").replace(",", "");
  var holidayRate = $(this).parent().parent().find("#txtHolidayRate").html().replace("₱&nbsp;", "").replace(",", "");
  $('.modal-title').html(roomType);
  $("#modalEditRoomType").find("#txtDescription").val(roomDescription);
  $("#modalEditRoomType").find("#txtRoomSimpDesc").val(roomSimpDesc);
  $("#modalEditRoomType").find("#txtIcon").val(icon);
  $("#modalEditRoomType").find("#txtCapacity").val(capacity);
  $("#modalEditRoomType").find("#txtRegularRate").val(regularRate);
  $("#modalEditRoomType").find("#txtSeasonRate").val(seasonRate);
  $("#modalEditRoomType").find("#txtHolidayRate").val(holidayRate);
});
$('.btnDeleteRoomID').click(function() {
  swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Delete'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        context: this,
        type: 'POST',
        url: root + 'ajax/deleteRoomID.php',
        data: "txtRoomID=" + $(this).attr("id") + "&csrf_token=" + $("input[name=csrf_token]").val(),
        success: function(response) {
          if (response == true) {
            swal({
              title: 'Deleted!',
              text: 'Room ID Deleted: ' + $(this).attr("id").replace("_", " "),
              type: 'success'
            }).then((result) => {
              if (result.value) {
                location.reload();
              }
            });
          } else {
            swal({
              title: 'Something went wrong!',
              text: 'Error: ' + response,
              type: 'warning'
            });
          }
        }
      });
    }
  });
});
$('.btnDeleteRoomType').click(function() {
  swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Delete'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        context: this,
        type: 'POST',
        url: root + 'ajax/deleteRoomType.php',
        data: "txtRoomType=" + $(this).attr("id") + "&csrf_token=" + $("input[name=csrf_token]").val(),
        success: function(response) {
          if (response == true) {
            swal({
              title: 'Deleted!',
              text: 'Room Type Deleted: ' + $(this).attr("id").replace("_", " "),
              type: 'success'
            }).then((result) => {
              if (result.value) {
                location.reload();
              }
            });
          } else {
            swal({
              title: 'Something went wrong!',
              text: 'Error: ' + response,
              type: 'warning'
            });
          }
        }
      });
    }
  });
});
$('#frmAddRoom').submit(function(e) {
  e.preventDefault();
  $(this).find("#btnAdd").html('<i style="font-size:16px" class="fa fa-spinner fa-pulse"></i> Adding...');
  $(this).find('#btnAdd').attr('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/addRoomID.php',
    data: $(this).serialize(),
    success: function(response) {
      if (response == true) {
        $('#modalAddRoom').modal('hide');
        alertNotif("success", ADD_SUCCESS, true);
      } else {
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>');
        });
        $(this).find("#btnAdd").html('Update');
        $(this).find('#btnAdd').attr('disabled', false);
      }
    }
  });
});
$('#frmAddRoomType').submit(function(e) {
  e.preventDefault();
  $(this).find("#btnAdd").html('<i style="font-size:16px" class="fa fa-spinner fa-pulse"></i> Adding...');
  $(this).find('#btnAdd').attr('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/addRoomType.php',
    data: $(this).serialize(),
    success: function(response) {
      if (response == true) {
        $('#modalAddRoomType').modal('hide');
        alertNotif("success", ADD_SUCCESS, true);
      } else {
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>');
        });
        $(this).find("#btnAdd").html('Update');
        $(this).find('#btnAdd').attr('disabled', false);
      }
    }
  });
});
$('#frmEditRoomID').submit(function(e) {
  e.preventDefault();
  $(this).find("#btnUpdate").html('<i style="font-size:16px" class="fa fa-spinner fa-pulse"></i>  Updating...');
  $(this).find('#btnUpdate').attr('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/editRoomID.php',
    data: $(this).serialize() + "&txtRoomID=" + $(".modal-title").html().replace("Room ID: ", ""),
    success: function(response) {
      if (response == true) {
        $('#modalEditRoomID').modal('hide');
        alertNotif("success", UPDATE_SUCCESS, true);
      } else {
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>');
        });
        $(this).find("#btnUpdate").html('Update');
        $(this).find('#btnUpdate').attr('disabled', false);
      }
    }
  });
});
$('#frmEditRoomType').submit(function(e) {
  e.preventDefault();
  $(this).find("#btnUpdate").html('<i style="font-size:16px" class="fa fa-spinner fa-pulse"></i>  Updating...');
  $(this).find('#btnUpdate').attr('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/editRoomType.php',
    data: $(this).serialize() + "&txtRoomType=" + $(".modal-title").html().replace(" ", "_"),
    success: function(response) {
      if (response == true) {
        $('#modalEditRoomType').modal('hide');
        alertNotif("success", UPDATE_SUCCESS, true);
      } else {
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>');
        });
        $(this).find("#btnUpdate").html('Update');
        $(this).find('#btnUpdate').attr('disabled', false);
      }
    }
  });
});
$("#loadingMode").fadeOut();