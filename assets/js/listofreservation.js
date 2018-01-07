$('#tblWalkIn').on('init.dt', function(e, settings, json) {
  $("#loadingMode").fadeOut();
});
$('#tblWalkIn').DataTable();
$('#tblBook').DataTable();
$('#tblWalkIn_length').find("select").addClass("form-control");
$('#tblWalkIn_filter').find("input[type=search]").addClass("form-control");
$('#tblBook_length').find("select").addClass("form-control");
$('#tblBook_filter').find("input[type=search]").addClass("form-control");
$('input[type="search"]').focus();