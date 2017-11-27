$('#tblRooms').fadeIn();
$('#tblRoomTypes').fadeIn();
$('.cbxRoom').change(function () {
  var status = $(this).prop('checked') ? "Enabled" : "Disabled";
  $.ajax({
    type: 'POST',
    url: '/files/changeStatus.php',
    data: 'roomID=' + $(this).attr("id") + "&status=" + status
  });
});

$('.btnEditRoom').click(function () {
  var roomType = $(this).attr("id").replace("_", " ");
  var roomDescription = $(this).parent().parent().find("#txtRoomDescription").html();
  $('.modal-title').html(roomType);
  $("#txtDescription").val(roomDescription);
});

$('#frmChangeRoom').submit(function (e) {
  e.preventDefault();
  $("#btnUpdate").html('<img src="' + root + 'images/btn-ajax-loader.gif" height="20px" width="20px" alt=""/> &nbsp; Updating...');
  $('#btnUpdate').attr('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'files/changeRoomDescription.php',
    data: $(this).serialize() + "&txtRoomType=" + $(".modal-title").html().replace(" ", "_"),
    success: function (response) {
      if (response == 'ok') {
        $('#modalEditRoom').modal('hide');
        alertNotif("success", "Updated Successfully!", true, 3000);
      }
    }
  });
});

function openTab(evt, category) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(category).style.display = "block";
  evt.currentTarget.className += " active";
}