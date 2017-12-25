$('#tblRooms').fadeIn();
$('#tblRoomTypes').fadeIn();
$('.cbxRoom').change(function() {
  var status = $(this).prop('checked') ? "Enabled" : "Disabled";
  $.ajax({
    type: 'POST',
    url: root + 'ajax/changeStatus.php',
    data: 'roomID=' + $(this).attr("id") + "&status=" + status
  });
});
$('.btnEditRoom').click(function() {
  var roomType = $(this).attr("id").replace("_", " ");
  var roomDescription = $(this).parent().parent().find("#txtRoomDescription").html();
  $('.modal-title').html(roomType);
  $("#txtDescription").val(roomDescription);
});
$('#frmChangeRoom').submit(function(e) {
  e.preventDefault();
  $(this).find("#btnUpdate").html('<i style="font-size:16px" class="fa fa-spinner fa-pulse"></i>  Updating...');
  $(this).find('#btnUpdate').attr('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/changeRoomDescription.php',
    data: $(this).serialize() + "&txtRoomType=" + $(".modal-title").html().replace(" ", "_"),
    success: function(response) {
      if (response == true) {
        $('#modalEditRoom').modal('hide');
        alertNotif("success", "Updated Successfully!", true);
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