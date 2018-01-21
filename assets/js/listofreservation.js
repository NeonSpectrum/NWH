$('#tblBooking').on('init.dt', function(e, settings, json) {
  $("#loadingMode").fadeOut();
});
var oTable = $('#tblBooking').DataTable();
$('#tblBooking_length').find("select").addClass("form-control");
$('#tblBooking_filter').find("input[type=search]").addClass("form-control");
$('input[type="search"]').focus();
if (getQueryVariable("search")) {
  $('input[type="search"]').val(getQueryVariable("search"));
  oTable.search(getQueryVariable("search")).draw();
}