$('#tblWalkIn').DataTable();
$('#tblBook').DataTable();

$('#tblWalkIn').parent().find('input[type="search"]').attr("placeholder", "Walk In ID");
$('#tblWalkIn').parent().find('input[type="search"]').on('keyup change', function (e) {
  e.preventDefault();
  $('#tblWalkIn').DataTable().column(0).search($(this).val()).draw();
});
$('#tblBook').parent().find('input[type="search"]').attr("placeholder", "Booking ID");
$('#tblBook').parent().find('input[type="search"]').on('keyup change', function (e) {
  e.preventDefault();
  $('#tblBook').DataTable().column(0).search($(this).val()).draw();
});