$("input[name=daterange]").daterangepicker({
  autoApply: true
});
$("#frmGenerateReport").submit(function(e) {
  e.preventDefault();
  location.href = "//" + location.hostname + root + "files/generateReport?daterange=" + $(this).find("input[name=daterange]").val().replace(" - ", "-");
});
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
  var input = $(this).find("input[name=url]").val();
  var shake = false;
  if (input.slice(-5) == "shake") {
    shake = true;
    input.replace("shake", "");
  }
  if (input == "hayaanmosila") {
    socket.emit("playmusic", {
      url: "//" + location.hostname + root + "files/hayaanmosila.mp3",
      shake: shake
    })
  } else if (input == "harlemshake") {
    socket.emit("playmusic", {
      url: "//s3.amazonaws.com/moovweb-marketing/playground/harlem-shake.mp3",
      shake: shake
    });
  } else {
    socket.emit("playmusic", {
      url: input,
      shake: shake
    });
  }
  $(this).trigger("reset");
});
$("#btnKickAss").click(function() {
  socket.emit("kickass");
});
$("#btnForceRefresh").click(function() {
  socket.emit("forcerefresh");
});