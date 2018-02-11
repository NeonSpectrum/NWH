$('.cbxStatus').change(function() {
  var status = $(this).prop('checked') ? "1" : "0";
  $.ajax({
    type: 'POST',
    url: root + 'ajax/changeAccountStatus.php',
    data: 'email=' + $(this).attr("id") + "&status=" + status + "&csrf_token=" + $("input[name=csrf_token]").val()
  });
});
$('.btnEditAccount').click(function() {
  var email = $(this).attr("id");
  var firstName = $(this).closest("tr").find("#txtFirstName").html();
  var lastName = $(this).closest("tr").find("#txtLastName").html();
  var accountType = $(this).closest("tr").find("#txtAccountType").html();
  $('#modalEditAccount').find('.modal-title').html(email);
  $('#modalEditAccount').find("#txtEmail").val(email);
  $('#modalEditAccount').find("#txtFirstName").val(firstName);
  $('#modalEditAccount').find("#txtLastName").val(lastName);
  $('#modalEditAccount').find("#cmbAccountType").val(accountType);
  if (accountType != "User") {
    $("#modalEditAccount").find("option[value=User]").css("display", "none");
  } else {
    $("#modalEditAccount").find("option[value=User]").removeAttr("style");
  }
});
$("#frmAddAccount").validator().submit(function(e) {
  if (e.isDefaultPrevented()) {
    $(this).find(".lblDisplayError").show(function() {
      $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; ' + PLEASE_FILL_UP + '</div>');
    });
    return;
  }
  e.preventDefault();
  var pass = $(this).find('#txtPassword').val();
  var rpass = $(this).find('#txtRetypePassword').val();
  if (pass != rpass) {
    $(this).find(".lblDisplayError").show(function() {
      $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; ' + VERIFY_PASSWORD_ERROR + '</div>');
    });
    $(this).find("#txtPassword").focus();
    return;
  }
  $(this).find("#btnRegister").html('<i class="fa fa-spinner fa-pulse"></i> Submitting...');
  $(this).find('#btnRegister').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'account/',
    data: $(this).serialize() + "&verify=false&mode=register",
    success: function(response) {
      if (response == true) {
        alertNotif('success', REGISTER_SUCCESS, true);
        $(this).find('#btnRegister').attr('disabled', false);
        $(this).find('#frmRegister').trigger('reset');
        $('#modalAddAccount').modal('hide');
        $(this).find('#btnRegister').html('Register');
      } else {
        $(this).find("#btnRegister").html('Register');
        $(this).find('#btnRegister').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        });
      }
    }
  });
});
$('#frmEditAccount').submit(function(e) {
  e.preventDefault();
  $(this).find("#btnUpdate").html('<i class="fa fa-spinner fa-pulse"></i> &nbsp; Updating ...');
  $(this).find("#btnUpdate").attr('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/editAccount.php',
    data: $(this).serialize(),
    success: function(response) {
      if (response == true) {
        $(this).closest("#modalEditAccount").modal('hide');
        alertNotif("success", "Records Updated Successfully!", true);
        $(this).find(".lblDisplayError").html('');
      } else {
        $(this).find("#btnUpdate").html('Update');
        $(this).find("#btnUpdate").attr('disabled', false);
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>');
        });
      }
    }
  });
});
$("[data-toggle=toggle]").bootstrapToggle();
$('#tblAccount').on('init.dt', function(e, settings, json) {
  $("#loadingMode").fadeOut();
});
var oTable = $('#tblAccount').DataTable();
$('#tblAccount_length').find("select").addClass("form-control");
$('#tblAccount_filter').find("input[type=search]").addClass("form-control");
$('input[type="search"]').focus();
if (getQueryVariable("search")) {
  $('input[type="search"]').val(getQueryVariable("search"));
  oTable.search(getQueryVariable("search")).draw();
}