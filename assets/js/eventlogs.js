$('#tblEvents').on('init.dt', function(e, settings, json) {
  $("#loadingMode").fadeOut();
});
$('#tblEvents').DataTable();
$('#tblEvents_length').find("select").addClass("form-control");
$('#tblEvents_filter').find("input[type=search]").addClass("form-control");
$('input[type="search"]').focus();