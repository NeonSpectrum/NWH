$("td.using, td.available").click(function() {
  $.ajax({
    type: 'POST',
    url: root + "ajax/getRoomInfo.php",
    data: "roomID=" + $(this).attr("id"),
    success: function(response) {}
  });
});