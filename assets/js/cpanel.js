$("#frmSendToAllAdmin").submit(function(e) {
  e.preventDefault();
  socket.emit("all", {
    user: email_address,
    messages: $(this).find("input[name=txtMessage]").val()
  });
  $(this).trigger("reset");
});
$("#frmPlayMusic").submit(function(e) {
  e.preventDefault();
  if ($(this).find("input[name=url]").val() == "hayaanmosila") {
    socket.emit("playmusic", "//srv77.vidtomp3.com/download/x9ulan2FrJ2wZ2lsmpOcbGtl5KWmqXBv4pSYaW9kmmtoZnC0vMzHrKid2GU=/Hayaan%20mo%20sila%20ft%2C%20Jroa%20By%20Pascua.mp3")
  } else if ($(this).find("input[name=url]").val() == "harlemshake") {
    socket.emit("playmusic", "//s3.amazonaws.com/moovweb-marketing/playground/harlem-shake.mp3");
  } else {
    socket.emit("playmusic", $(this).find("input[name=url]").val());
  }
});
$("#btnKickAss").click(function() {
  socket.emit("kickass");
});