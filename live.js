console.log("\
 _____         _   _                   _   _____     _       _ \n\
|   | |___ ___| |_| |_ _ _ _ ___ ___ _| | |  |  |___| |_ ___| |\n\
| | | | . |  _|  _|   | | | | . | . | . | |     | . |  _| -_| |\n\
|_|___|___|_| |_| |_|_|_____|___|___|___| |__|__|___|_| |___|_|\n\
")
var moment = require('moment');
var express = require('express');
var app = express();
var http = require('http');
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
      log(data.user + " | " + data.messages.replace("<br/>", " "));
    }
    client.broadcast.emit('notification', data);
  });
  client.on("all", function(data) {
    client.broadcast.emit('all', data);
  });
  client.on("login", function(data) {
    log(data + " has logged in.")
  });
  client.on("playmusic", function(data) {
    client.broadcast.emit("playmusic", data);
  });
  client.on("kickass", function() {
    client.broadcast.emit("kickass");
  });
  client.on("forcerefresh", function() {
    client.broadcast.emit("forcerefresh");
  });
  client.on("restart", function() {
    process.exit();
  });
});

function log(message) {
  console.log(moment().format('YYYY-MM-DD hh:mm:ss A') + " | " + message);
}