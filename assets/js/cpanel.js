$("#frmSendToAllAdmin").submit(function(e) {
  e.preventDefault();
  socket.emit("all", {
    user: email_address,
    messages: $(this).find("input[name=txtMessage]").val()
  });
  $(this).trigger("reset");
});
$("#btnHarlemShake").click(function() {
  socket.emit("harlemshake");
});
$("#btnKickAss").click(function() {
  socket.emit("kickass");
});