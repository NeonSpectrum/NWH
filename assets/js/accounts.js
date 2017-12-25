var oTable = $('#tblAccount').DataTable();
$('#tblAccount_length').find("select").addClass("form-control");
$('#tblAccount_filter').find("input[type=search]").addClass("form-control");
$('input[type="search"]').focus();
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
});
$('.btnDeleteAccount').click(function() {
  var email = $(this).attr("id");
  swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        type: 'POST',
        url: root + 'account/',
        data: "txtEmail=" + email + "&mode=deleteAccount",
        success: function(response) {
          if (response == true) {
            swal({
              title: 'Deleted!',
              text: 'The account has been deleted.',
              type: 'success'
            }).then((result) => {
              if (result.value) {
                location.reload();
              }
            });
          } else {
            swal({
              title: 'Error',
              text: 'There was an error deleting the account!',
              type: 'error'
            });
          }
        }
      });
    }
  })
});
$("#frmAddAccount").validator().submit(function(e) {
  if (e.isDefaultPrevented()) {
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
  $(this).find("#btnUpdate").html('<img src="' + root + '/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating ...');
  $(this).find("#btnUpdate").attr('disabled', true);
  if ($(this).find('#cmbAccountType').val() != "User" && $(this).find('#cmbAccountType').val() != "Admin") {
    $(this).find(".lblDisplayError").show(function() {
      $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; Invalid Account Type</div>');
    });
    $(this).find("#btnUpdate").html('Update');
    $(this).find("#btnUpdate").attr('disabled', false);
    return;
  }
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