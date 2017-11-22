var express = require('express'),
  app = express(),
  http = require('http').Server(app),
  mysql_connection = require('./models/db.js'),
  data_controller = require('./controller/dataController.js'),
  game_controller = require('./controller/gameController.js'),
  coin_model = new(require('./models/coinModel.js'))(),
  game_model = new(require('./models/gameModel.js'))(),
  moment = require('moment'),
  Pusher = require('pusher'),
  pusher = new Pusher({
    appId: '416493',
    key: '802fc577223f4567a8df',
    secret: '251f06b4c247f87f7593',
    cluster: 'ap1',
    encrypted: true
  });

/*=====START=====Router============*/
app.use(express.static('public'));
app.use(function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  next();
});
app.get('/api/bitcoin', function(req, res) {
  coin_model.getCoinRate(mysql_connection, function(result) {
    res.jsonp(result);
  });
});
/*=====END=====Router============*/

/*=====START=====Controllers============*/

data_controller.getData(pusher, mysql_connection);
game_controller.sys_game_controller_running;
pusher.trigger('system_game', 'pop_winner',{
  message: 'hello'
})

/*=====END======Controllers============*/



http.listen(3333, function() {
  mysql_connection.connect(function(err) {
    if (err) throw err;
    console.log('connected to database!\n');
  });
  console.log('\nlistening on *:3333\n');
  console.log('System game controller is running ... \n');
  console.log('Bitcoin data controller is running ... \n');
});