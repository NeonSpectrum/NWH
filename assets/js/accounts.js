$(document).ready(function () {
  $("#cmbEmail").change(function () {
    $.ajax({
      url: "../../files/displayAccount.php",
      type: "POST",
      dataType: "json",
      data: $('#frmAccount').serialize(),
      success: function (data) {
        if (data[0] == 'error') {
          $("#cmbAccountType").val("");
          $("#txtFirstName").val("");
          $("#txtLastName").val("");
          return;
        }
        $("#cmbAccountType").val(data[0]);
        $("#txtFirstName").val(data[1]);
        $("#txtLastName").val(data[2]);
      }
    });
  });
});

function submitEditForm() {
  $("#btnEdit").html('<img src="/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Editing ...');
  $("#btnEdit").attr('disabled', true);
  $.ajax({
    type: 'POST',
    url: '../../files/editAccount.php',
    data: $("#frmAccount").serialize(),
    success: function (response) {
      if (response == "ok") {
        alertNotif("success", "Records Updated Successfully!", true);
      } else {
        $("#btnEdit").html('Edit');
        $("#btnEdit").attr('disabled', false);
        $("#lblErrorDisplayAccount").fadeIn(1000, function () {
          $("#lblErrorDisplayAccount").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>')
        });
      }
    }
  });
  return false;
}