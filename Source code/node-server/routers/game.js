var express = require('express'),
    router = express.Router(),
	mysql = require('./../models/db.js'),
	game_model = new(require('./../models/gameModel.js'))(),
    game_controller = new(require('./../controller/gameController.js'))(),
    schedule = require('node-schedule');

router.post('/yngame', function(req, res){
	let game = req.body;
	game_model.get_yn_game_by_id(game.GAME_ID)
	.then(game_info => {
		let date_schedule = new Date(game_info.END_DATE);
		date_schedule.setSeconds(date_schedule.getSeconds() + 2);
		schedule.scheduleJob(date_schedule, function() {
			game_controller.yn_award_users(game_info);
		});
		console.log('*(YN_GAMES)New YN_GAME was created at ' + game_info.START_DATE + ' ...\n');
	});
	res.end();
});
router.post('/multigame', function(req, res){
	let game = req.body;
	game_model.get_multi_game_by_id(game.GAME_ID)
	.then(game_info => {
		let date_schedule = new Date(game_info.END_DATE);
		date_schedule.setSeconds(date_schedule.getSeconds() + 2);
		schedule.scheduleJob(date_schedule, function() {
			game_controller.multi_award_users(game_info);
		});
		console.log('*(MULTI_CHOICE_GAME)New MULTI_CHOICE_GAME was created at ' + game_info.START_DATE + ' ...\n');
	});
	res.end();
});
// system game demo
router.post('/systemgame', function(req, res){
	let game = req.body;
	game_model.get_system_game_by_id(game.GAME_ID)
	.then((game_info)=>{
		let date_schedule = new Date(game_info.END_DATE);
		date_schedule.setSeconds(date_schedule.getSeconds() + 2);
		schedule.scheduleJob(date_schedule, function() {
			game_controller.system_game_demo();
		});
		console.log('*(SYSTEM_GAME) The end of game was changed to ' + game_info.END_DATE + ' ...\n');
	})
	res.end();
});

module.exports = router;