// Setup basic express server
var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = require('socket.io')(server);
var redis = require('socket.io-redis');
var port = process.env.PORT || 3000;
var serverName = process.env.NAME || 'Unknown';

io.adapter(redis({ host: 'redis', port: 6379 }));


// Chatroom
var users = [];

server.listen(port, function () {
  console.log('Server listening at port %d', port);
  console.log('Hello, I\'m %s, how can I help?', serverName);
});

// Routing
app.use(express.static(__dirname + '/public'));

io.on('connection', function (socket) {

  var addedUser = false;
  socket.on('restart', function (data) {
    // we tell the client to execute 'BroadCastNotification'
    socket.broadcast.emit('restart', 'now');
  });
  // when the client emits 'BroadCastNotification', this listens and executes
  socket.on('Notification_', function (data) {
    // we tell the client to execute 'BroadCastNotification'
    socket.broadcast.emit('Notification Room ' + data.room, {
      username: socket.username,
      message: data
    });
  });
  // when the client emits 'BroadCastNotification', this listens and executes
  socket.on('BroadCastNotification', function (data) {
    // we tell the client to execute 'BroadCastNotification'
    console.log(data)
    socket.broadcast.emit('BroadCastNotification', {
      username: socket.username,
      message: data
    });
  });

  // when the client emits 'Subscribe', this listens and executes
  socket.on('Subscribe', function (username) {
    if (addedUser) return;
    // we store the username in the socket session for this client
    socket.username = username
    users.push(username);
    addedUser = true;
    socket.emit('login', {
      users: users,
    });
    // echo globally (all clients) that a person has connected
    socket.broadcast.emit('user joined', {
      username: socket.username,
    });
  });

  // when the client emits 'typing', we broadcast it to others
  socket.on('typing', function () {
    socket.broadcast.emit('typing', {
      username: socket.username
    });
  });

  // when the client emits 'stop typing', we broadcast it to others
  socket.on('stop typing', function () {
    socket.broadcast.emit('stop typing', {
      username: socket.username
    });
  });

  // when the user disconnects.. perform this
  socket.on('disconnect', function () {
    if (addedUser) {
      users.splice(users.indexOf(socket.username), 1)
      // echo globally that this client has left
      socket.broadcast.emit('user left', {
        username: socket.username
      });
    }
  });

  socket.on('Monitoring', function(watched) {
    console.log(watched);
    socket.broadcast.emit('Monitoring', watched);
  })
});


