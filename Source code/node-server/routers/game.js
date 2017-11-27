var express = require('express'),
    router = express.Router(),
    mysql = require('./../models/db.js'),
    game_controller = require('./../controller/gameController.js'),
    schedule = require('node-schedule');

router.post('/yngame', function(req, res){
	let game = req.body;
	console.log(game);
/*	//needed: GAME_ID, END_DATE("%Y-%m-%d %H:%i:00"), TOTAL_AMOUNT, OWNER_ID
	//or load from db
	let date_schedule = new Date(game.END_DATE);
			date_schedule.setSeconds(date_schedule.getSeconds() + 1);
	schedule.scheduleJob(date_schedule, ()=>{
		//load total amount
		//game_controller.yn_award_users(game);
		console.log('hello anh phong');
	});*/
	// console.log('*New YN_GAMES is create at ...');
	res.end();
});
router.post('/multigame', function(req, res){
	let game = req.body;
	console.log(game);
	res.end();
});

module.exports = router;