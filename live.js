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
var io = require('socket.io').listen(http.createServer(app).listen(port = 8755, function() {
  log("Server started at port " + port)
}))
var db = mysql.createConnection({
  host: config.system.database_url,
  user: "cp018101",
  password: "Yangyuanhua12",
  database: "cp018101_nwh"
})
var notifytime = 5000
var now = moment().format('YYYY-MM-DD HH:mm:ss')
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
    var query = "INSERT INTO notification VALUES(NULL,'" + data.type + "','" + data.messages + "',0,'" + now + "')"
    db.query(query, function(err, result) {
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
  client.on("restart", function() {
    process.exit()
  })
  setInterval(function() {
    var query = "SELECT booking.BookingID FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE CheckInDate < CURDATE() AND CheckIn IS NULL"
    db.query(query, function(err, row) {
      for (var i = 0; i < row.length; i++) {
        var bookingID = row[0].BookingID
        formatBookingID(bookingID, function(result) {
          bookingID = result
          var message = "Please be reminded that " + bookingID + " haven't check in yet."
          db.query("SELECT * FROM notification WHERE Message=? AND DATE(TimeStamp)=CURDATE()", [message], function(err, result) {
            if (result.length == 0) {
              db.query("INSERT INTO notification VALUES(NULL,'exclamation-triangle',?,0,?)", [message, now], function(err, insert) {
                io.emit("notification", {
                  id: insert.insertId,
                  type: 'exclamation-triangle',
                  messages: message,
                  time: moment().format('MMM DD hh:mm A')
                })
              })
            }
          })
        })
      }
    })
  }, notifytime)
})

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