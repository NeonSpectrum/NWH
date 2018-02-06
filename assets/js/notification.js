$('#tblNotification').on('init.dt', function(e, settings, json) {
  $("#loadingMode").fadeOut();
});
var oTable = $('#tblNotification').DataTable({
  "scrollY": "300px",
  "scrollCollapse": true
});
oTable.order([0, 'desc']).draw();
$('#tblNotification_length').find("select").addClass("form-control");
$('#tblNotification_filter').find("input[type=search]").addClass("form-control");
$('input[type="search"]').focus();
if (getQueryVariable("search")) {
  $('input[type="search"]').val(getQueryVariable("search"));
  oTable.search(getQueryVariable("search")).draw();
}