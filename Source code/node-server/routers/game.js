var express = require('express'),
    router = express.Router(),
	mysql = require('./../models/db.js'),
	game_model = new(require('./../models/gameModel.js'))(),
    game_controller = require('./../controller/gameController.js'),
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
		console.log('*(YN_GAMES)New YN_GAME is created at ' + game_info.START_DATE + ' ...\n');
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
		console.log('*(MULTI_CHOICE_GAME)New MULTI_CHOICE_GAME is created at ' + game_info.START_DATE + ' ...\n');
	});
	res.end();
});

module.exports = router;