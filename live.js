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
var https = require('https')
var fs = require('fs')
var ini = require('ini')
var config = ini.parse(fs.readFileSync('./config.ini', 'utf-8'))
var crypto = require('crypto'),
  algorithm = 'aes-256-ctr',
  password = '1ff8cc6708848c57e84e67d67f599156';
var io = null;
var db = mysql.createConnection({
  host: config.system.database_url,
  user: "cp018101",
  password: decrypt("2da795d3d7fe2aaa21a9b66944"),
  database: "cp018101_nwh"
})
var notifytime = 5
db.connect(function(err) {
  if (err) {
    console.log(err.sqlMessage)
    process.exit()
  }
  log("Database Connected!")
})
if (config.system.node_js_url.indexOf("https") === -1) {
  io = require('socket.io').listen(http.createServer(app).listen(port = 8755, function() {
    log("Http Server started at port " + port)
  }))
} else {
  io = require('socket.io').listen(https.createServer({
    ca: fs.readFileSync('./key/ca_bundle.crt'),
    key: fs.readFileSync('./key/private.key'),
    cert: fs.readFileSync('./key/certificate.crt')
  }, app).listen(port = 8755, function() {
    log("Https Server started at port " + port)
  }))
}
io.on('connection', function(client) {
  client.on("access", function(data) {
    log(data + " accessed: " + client.handshake.headers.referer, "Access")
  })
  client.on("notification", function(data) {
    data.time = moment().format('MMM DD hh:mm A')
    db.query("INSERT INTO notification VALUES(NULL,?,?,0,?)", [data.type, data.messages, moment().format('YYYY-MM-DD HH:mm:ss')], function(err, result) {
      data.id = result.insertId
      log("New Notification from " + data.user + ": " + data.messages.replace(/<(?:.|\n)*?>/gm, ''), "Notif ")
      io.emit('notification', data)
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
    db.query("SELECT * FROM account WHERE EmailAddress=?", [data.email], function(err, row) {
      if (row[0].AccountType == "User" && row[0].SessionID == data.session) {
        client.broadcast.emit("logout", data.email);
      }
    })
    log(data.email + " has logged in.", "Logged")
  })
  client.on("playmusic", function(data) {
    client.broadcast.emit("playmusic", data)
  })
  client.on("kickass", function() {
    client.broadcast.emit("kickass")
  })
  client.on("forcerefresh", function(data) {
    client.broadcast.emit("forcerefresh", data);
  })
  client.on("shutdown", function() {
    client.broadcast.emit("shutdown")
  })
  client.on("restart", function() {
    process.exit()
  })
})
setInterval(function() {
  var query = "SELECT booking.BookingID,CheckInDate FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID LEFT JOIN booking_cancelled ON booking.BookingID=booking_cancelled.BookingID WHERE CheckIn IS NULL AND DateCancelled IS NULL"
  db.query(query, function(err, row) {
    for (var i = 0; i < row.length; i++) {
      if (moment(row[i].CheckInDate, "YYYY-MM-DD").add(1, "days").format("YYYY-MM-DD") <= moment().format("YYYY-MM-DD")) {
        formatBookingID(row[i].BookingID, function(result) {
          var bookingID = result
          var message = "Please be reminded that <a href='/" + (config.system.hostname == 'localhost' ? "nwh/" : "") + "admin/booking/?search=" + bookingID + "'>" + bookingID + "</a> haven't check in yet."
          db.query("SELECT * FROM notification WHERE Message=?", [message], function(err, result) {
            var notAvailable = true;
            for (var j = 0; j < result.length; j++) {
              if (moment(result[j].TimeStamp, "YYYY-MM-DD").format("YYYY-MM-DD") == moment().format("YYYY-MM-DD")) {
                notAvailable = false;
              }
            }
            if (notAvailable) {
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
  dec += decipher.final('utf8')
  return dec
}