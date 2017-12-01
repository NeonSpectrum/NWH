var oTable = $('#tblReservation').DataTable();
$('input[type="search"]').attr("placeholder", "Booking ID");
$('input[type="search"]').on('keyup change', function (e) {
  e.preventDefault();
  oTable.column(0).search($(this).val()).draw();
});