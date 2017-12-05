var oTable = $('#tblAccount').DataTable();
$('input[type="search"]').attr("placeholder", "Email Address");
$('input[type="search"]').on('keyup change', function (e) {
  e.preventDefault();
  oTable.column(0).search($(this).val()).draw();
});

$('.btnEditAccount').click(function () {
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
$('.btnDeleteAccount').click(function () {
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
        url: root + 'ajax/deleteAccount.php',
        data: "txtEmail=" + email,
        success: function (response) {
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
          }
        }
      });
    }
  })
});
$("#frmAddAccount").submit(function (e) {
  e.preventDefault();
  var pass = $(this).find('#txtPassword').val();
  var rpass = $(this).find('#txtRetypePassword').val();
  if (pass != rpass) {
    $(this).find(".lblDisplayError").show(function () {
      $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; ' + VERIFY_PASSWORD_ERROR + '</div>');
    });
    $(this).find("#txtPassword").focus();
    return;
  }
  $(this).find("#btnRegister").html('<i class="fa fa-spinner fa-pulse"></i> Submitting...');
  $(this).find('#btnRegister').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  console.log("hello");
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'account/register.php',
    data: $(this).serialize() + "&type=noverify",
    success: function (response) {
      if (response == true) {
        alertNotif('success', 'Registered Successfully', true);
        $(this).find('#btnRegister').attr('disabled', false);
        $(this).find('#frmRegister').trigger('reset');
        $('#modalAddAccount').modal('hide');
        $(this).find('#btnRegister').html('Register');
      } else {
        $(this).find("#btnRegister").html('Register');
        $(this).find('#btnRegister').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function () {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        });
      }
    }
  });
});

$('#frmEditAccount').submit(function (e) {
  e.preventDefault();
  $(this).find("#btnUpdate").html('<img src="' + root + '/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating ...');
  $(this).find("#btnUpdate").attr('disabled', true);
  if ($(this).find('#cmbAccountType').val() != "User" && $(this).find('#  cmbAccountType').val() != "Admin") {
    $(this).find(".lblDisplayError").show(function () {
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
    success: function (response) {
      if (response == true) {
        $(this).closest("#modalEditAccount").modal('hide');
        alertNotif("success", "Records Updated Successfully!", true);
        $(this).find(".lblDisplayError").html('');
      } else {
        $(this).find("#btnUpdate").html('Update');
        $(this).find("#btnUpdate").attr('disabled', false);
        $(this).find(".lblDisplayError").show(function () {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>');
        });
      }
    }
  });
});