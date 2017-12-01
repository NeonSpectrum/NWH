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