var express = require('express');
var app = express();
var http = require('http');
var path = require('path');
var fs = require('fs');
var io = require('socket.io').listen(http.createServer(app).listen(port = 8080, function() {
  console.log("Server started at port " + port);
}));
io.on('connection', function(client) {
  client.on('notification', function(data) {
    console.log(data.messages);
    io.emit('notification', data);
  });
});