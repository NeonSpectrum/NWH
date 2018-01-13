console.log("\
 _____             _____             _                 \n\
|   | |___ ___ ___|   __|___ ___ ___| |_ ___ _ _ _____ \n\
| | | | -_| . |   |__   | . | -_|  _|  _|  _| | |     |\n\
|_|___|___|___|_|_|_____|  _|___|___|_| |_| |___|_|_|_|\n\
                        |_|                            \n\
")
var moment = require('moment');
var express = require('express');
var app = express();
var http = require('http');
var path = require('path');
var fs = require('fs');
var io = require('socket.io').listen(http.createServer(app).listen(port = 8755, function() {
  log("Server started at port " + port);
}));
io.on('connection', function(client) {
  client.on("access", function(data) {
    log(data + " accessed: " + client.handshake.headers.referer);
  });
  client.on("notification", function(data) {
    if (!data.messages.startsWith("Logged")) {
      log(data.messages.replace("<br/>", " "));
    }
    io.emit('notification', data);
  });
  client.on("login", function(data) {
    log(data + " has logged in.")
  });
});

function log(message) {
  console.log(moment().format('YYYY-MM-DD hh:mm:ss A') + " | " + message);
}