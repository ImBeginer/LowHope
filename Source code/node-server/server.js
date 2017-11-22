var express = require('express'),
  app = express(),
  http = require('http').Server(app),
  data_controller = require('./controller/dataController.js'),
  game_controller = require('./controller/gameController.js'),
  coin_model = new(require('./models/coinModel.js'))(),
  game_model = new(require('./models/gameModel.js'))(),
  pusher = require('./third-partyservice/pusher.js'),
  mysql = require('./models/db.js');
mysql.connect(function(err) {
  if (err) throw err;
  console.log('connected to database!\n');
});
var user_model = new(require('./models/userModel.js'))();

/*=====START=====Router============*/
app.use(express.static('public'));
app.use(function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  next();
});
app.get('/api/bitcoin', function(req, res) {
  coin_model.getCoinRate(mysql, function(result) {
    res.jsonp(result);
  });
});
/*=====END=====Router============*/

/*=====START=====Controllers============*/

data_controller.getData(pusher, mysql);
game_controller.sys_game_controller_running;
// game_controller.yn_game_controller_running();

/*=====END======Controllers============*/



http.listen(3333, function() {
  console.log('\nlistening on *:3333\n');
  console.log('System game controller is running ... \n');
  console.log('Bitcoin data controller is running ... \n');
});