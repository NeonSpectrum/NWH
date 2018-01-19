$("#frmSendToAllAdmin").submit(function(e) {
  e.preventDefault();
  socket.emit("all", {
    user: email_address,
    messages: "Message: " + $(this).find("input[name=txtMessage]").val()
  });
  $(this).trigger("reset");
});