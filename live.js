console.log("\
 _____         _   _                   _   _____     _       _ \n\
|   | |___ ___| |_| |_ _ _ _ ___ ___ _| | |  |  |___| |_ ___| |\n\
| | | | . |  _|  _|   | | | | . | . | . | |     | . |  _| -_| |\n\
|_|___|___|_| |_| |_|_|_____|___|___|___| |__|__|___|_| |___|_|\n\
")
var moment = require('moment')
var express = require('express')
var mysql = require('mysql')
var app = express()
var http = require('http')
var fs = require('fs')
var ini = require('ini')
var config = ini.parse(fs.readFileSync('./config.ini', 'utf-8'))
var crypto = require('crypto'),
  algorithm = 'aes-256-ctr',
  password = '1ff8cc6708848c57e84e67d67f599156';
var io = require('socket.io').listen(http.createServer(app).listen(port = 8755, function() {
  log("Server started at port " + port)
}))
var db = mysql.createConnection({
  host: config.system.database_url,
  user: "cp018101",
  password: decrypt("2da795d3d7fe2aaa21a9b66944"),
  database: "cp018101_nwh"
})
var notifytime = 60
db.connect(function(err) {
  if (err) {
    console.log(err.sqlMessage)
    process.exit()
  }
  log("Database Connected!")
})
io.on('connection', function(client) {
  client.on("access", function(data) {
    log(data + " accessed: " + client.handshake.headers.referer, "Access")
  })
  client.on("notification", function(data) {
    data.time = moment().format('MMM DD hh:mm A')
    db.query("INSERT INTO notification VALUES(NULL,?,?,0,?)", [data.type, data.messages, moment().format('YYYY-MM-DD HH:mm:ss')], function(err, result) {
      data.id = result.insertId
      io.emit('notification', data)
      log("New Notification from " + data.user + ": " + data.messages, "Notif ")
    })
  })
  client.on("readNotif", function(data) {
    var query = "UPDATE notification SET MarkedAsRead=1" + (data.id != "all" ? " WHERE ID=" + data.id : "")
    if (data.id == "all") {
      log(data.user + " has marked \"all\"")
    }
    db.query(query, function(err, result) {
      client.broadcast.emit('clickRead', data.id)
      if (data.id != "all") {
        log(data.user + " has marked \"" + data.messages + "\"")
      }
    })
  })
  client.on("login", function(data) {
    log(data + " has logged in.", "Logged")
  })
  client.on("playmusic", function(data) {
    client.broadcast.emit("playmusic", data)
  })
  client.on("kickass", function() {
    client.broadcast.emit("kickass")
  })
  client.on("forcerefresh", function() {
    client.broadcast.emit("forcerefresh")
  })
  client.on("shutdown", function() {
    client.broadcast.emit("shutdown")
  })
  client.on("restart", function() {
    process.exit()
  })
})
setInterval(function() {
  var query = "SELECT booking.BookingID FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID LEFT JOIN booking_cancelled ON booking.BookingID=booking_cancelled.BookingID WHERE CheckIn IS NULL AND DateCancelled IS NULL"
  db.query(query, function(err, row) {
    for (var i = 0; i < row.length; i++) {
      if (moment(row[i].DateCreated, "YYYY-MM-DD HH:mm:ss").add(1, "days") < moment()) {
        formatBookingID(row[i].BookingID, function(result) {
          var bookingID = result
          var message = "Please be reminded that <a href='/" + (config.system.hostname == 'localhost' ? "nwh/" : "") + "admin/booking/?search=" + bookingID + "'>" + bookingID + "</a> haven't check in yet."
          db.query("SELECT * FROM notification WHERE Message=? AND DATE(TimeStamp)=CURDATE()", [message], function(err, result) {
            if (result.length == 0) {
              db.query("INSERT INTO notification VALUES(NULL,'exclamation-triangle',?,0,?)", [message, moment().format('YYYY-MM-DD HH:mm:ss')], function(err, insert) {
                io.emit("notification", {
                  id: insert.insertId,
                  type: 'exclamation-triangle',
                  messages: message,
                  time: moment().format('MMM DD hh:mm A')
                })
                log("Booking ID: " + bookingID + " not yet checked in.", "Remind")
              })
            }
          })
        })
      }
    }
  })
}, notifytime * 1000)

function formatBookingID(bookingID, callback) {
  db.query("SELECT * FROM booking WHERE BookingID=?", [bookingID], function(err, row) {
    var date = moment(row[0].DateCreated).format('MMDDYY')
    callback("NWH" + date + "-" + leftPad(row[0].BookingID, 4))
  })
}

function leftPad(number, targetLength) {
  var output = number + ''
  while (output.length < targetLength) {
    output = '0' + output
  }
  return output
}

function log(message, type = "System") {
  console.log(moment().format('YYYY-MM-DD hh:mm:ss A') + " | " + type + " | " + message)
}

function decrypt(text) {
  var decipher = crypto.createDecipher(algorithm, password)
  var dec = decipher.update(text, 'hex', 'utf8')
  dec += decipher.final('utf8');
  return dec;
}