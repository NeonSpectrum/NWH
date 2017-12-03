// $(document).ready(function () {
//   $.ajax({
//     url: root + 'ajax/cmbEmailDisplay.php',
//     type: "POST",
//     dataType: "json",
//     data: $('#frmAccount').serialize(),
//     success: function (data) {
//       $("#cmbAccountType").val(data[0]);
//       $("#txtFirstName").val(data[1]);
//       $("#txtLastName").val(data[2]);
//     }
//   });
// });
// $("#cmbEmail").change(function () {
//   $.ajax({
//     url: root + 'ajax/cmbEmailDisplay.php',
//     type: "POST",
//     dataType: "json",
//     data: $('#frmAccount').serialize(),
//     success: function (data) {
//       $("#cmbAccountType").val(data[0]);
//       $("#txtFirstName").val(data[1]);
//       $("#txtLastName").val(data[2]);
//     }
//   });
// });

// $('#frmAccount').submit(function (e) {
//   e.preventDefault();
//   $(this).find("#btnEdit").html('<i style="font-size:16px" class="fa fa-spinner fa-pulse"></i> Updating ...');
//   $(this).find("#btnEdit").attr('disabled', true);
//   $.ajax({
//     context: this,
//     type: 'POST',
//     url: root + 'ajax/editAccount.php',
//     data: $(this).serialize(),
//     success: function (response) {
//       if (response) {
//         alertNotif("success", "Records Updated Successfully!");
//         $(this).find("#lblDisplayError").html('');
//       } else {
//         $(this).find("#btnEdit").html('Update');
//         $(this).find("#btnEdit").attr('disabled', false);
//         $(this).find(".lblDisplayError").show(function () {
//           $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>');
//         });
//       }
//     }
//   });
// });

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
  $('.modal-title').html(email);
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
            swal(
              'Deleted!',
              'The account has been deleted.',
              'success'
            )
            setTimeout(location.reload(), 1000);
          }
        }
      });
    }
  })
});
$('#frmEditAccount').submit(function (e) {
  e.preventDefault();
  $(this).find("#btnUpdate").html('<img src="' + root + '/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating ...');
  $(this).find("#btnUpdate").attr('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/editAccount.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response) {
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