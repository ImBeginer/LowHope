var express = require('express'),
  app = express(),
  bodyParser = require('body-parser'),
  http = require('http').Server(app),
  data_controller = require('./controller/dataController.js'),
  game_controller = require('./controller/gameController.js'),
  user_controller = require('./controller/userController.js'),
  coin_model = new(require('./models/coinModel.js'))(),
  game_model = new(require('./models/gameModel.js'))(),
  mysql = require('./models/db.js'),
  coin_router = require('./routers/bitcoin.js'),
  game_router = require('./routers/game.js'),
  notice_model = new(require('./models/noticeModel.js'))(),
  user_model = new(require('./models/userModel.js'))();


mysql.connect(function(err) {
  if (err) throw err;
  console.log('connected to database!\n');
});

/*=====START=====Router============*/
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));
app.use(express.static('public'));
app.use(function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  next();
});
app.use('/api/bitcoin', coin_router);
app.use('/api/game', game_router);

/*=====END=====Router============*/

/*=====START=====Controllers============*/

data_controller.getData();
/* game_controller.sys_game_schedule(); */
user_controller.reset_user_attendance();
game_controller.sys_game_controller_running();
game_controller.yn_game_controller_running();
game_controller.multi_game_controller_running();
/*=====END======Controllers============*/



http.listen(3333, function() {
  console.log('\nlistening on *:3333\n');
  console.log('System game controller is running ... \n');
  console.log('Bitcoin data controller is running ... \n');
});