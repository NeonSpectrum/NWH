$('#tblCancelledBooking').on('init.dt', function(e, settings, json) {
  $("#loadingMode").fadeOut();
});
var oTable = $('#tblCancelledBooking').DataTable();
$('#tblCancelledBooking_length').find("select").addClass("form-control");
$('#tblCancelledBooking_filter').find("input[type=search]").addClass("form-control");
$('input[type="search"]').focus();
if (getQueryVariable("search")) {
  $('input[type="search"]').val(getQueryVariable("search"));
  oTable.search(getQueryVariable("search")).draw();
}