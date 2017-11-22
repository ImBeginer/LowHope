var game_model = new(require('./../models/gameModel.js'))(),
	coin_model = new(require('./../models/coinModel.js'))(),
	user_model = new(require('./../models/userModel.js'))(),
	mysql = require('./../models/db.js'),
	moment = require('moment'),
	async = require('async'),
	q = require('q'),
	schedule = require('node-schedule');
/*=====START=====Additional functions============*/
function find_winners(date, callback) {
	game_model.get_guess_onactive(mysql, date, function(data) {
		if (data.constructor === Array) {
			var winners = [];
			if (data.length === 1) {
				winners.push(data[0]);
				return callback(winners);
			} else if (data.length === 2) {
				winners.push(data[0], data[1]);
				return callback(winners);
			} else {
				winners.push(data[0], data[1], data[2]);
				return callback(winners);
			}
			return callback(winners);
		} else {
			return callback(data);
		}
	});
};

function create_new_game() {
	var start_date = moment().format('YYYY-MM-DD HH:mm:ss'),
		end_date = moment().add(4, 'days').format('YYYY-MM-DD');

	var data = {
		TITLE: "Có ngon vào thử",
		CONTENT: "Giá bitcoin ngày " + moment(end_date).format('DD-MM-YYYY') + " vào lúc " + moment(end_date).format('HH:mm:ss'),
		START_DATE: start_date,
		END_DATE: end_date,
		ACTIVE: 1,
		POINT_TO_BET: 15,
		CUR_TYPE_ID: 1
	}

	game_model.create_new_system_game(mysql, data, function(res) {
		console.log('New game is opened!\n');
	});
};

function yn_award_users(connection, game) {
	game_model.get_yn_game_winners(mysql, [game.END_DATE, game.GAME_ID])
		.then((winners) => {
			user_model.update_users_points(connection, winners);
			user_model.get_user_point(connection, game.OWNER_ID)
				.then((point) => {
					var remaining_amount = game.TOTAL_AMOUNT - winners.length * 20;
					user_model.update_user_points(mysql, [(point + remaining_amount), game.OWNER_ID])
						.then((res) => {
							game_model.update_yn_game_result(mysql, [winners[0].RESULT, game.GAME_ID])
								.then((res) => {
									console.log('Game id: ' + game.GAME_ID + ' closed!\n');
								});
						})
				});
		})
		.catch((err) => {
			console.log(err);
		});
}

/*=====END=======Additional functions============*/
/*=====START======function for schedule============*/
var sys_game_schedule = function() {
	// get active game
	game_model.get_active_sys_game(mysql, function(active_game) {
		if (active_game != null) {
			var end_date = moment(active_game.END_DATE).format("YYYY-MM-DD");
			var isDeadline = end_date == moment().format("YYYY-MM-DD");
			if (!isDeadline) {
				sys_game_job.cancel();
				console.log('Today is not the end of system game!\n');
			} else {
				//find winners at deadline
				find_winners(active_game.END_DATE, function(winners) {
					//award user
					winners.forEach(function(winner, index) {
						var data = {
							USER_ID: winner.USER_ID,
							AWARD_ID: index + 1,
							GAME_ID: active_game.GAME_ID,
							GET_AT: moment().format('YYYY-MM-DD HH:mm:ss')
						};
						game_model.sys_award_user(mysql, data, function(res) {
							console.log(winner.USER_NAME + ' was awarded!\n');
						})

					});

					// add notification to db
					//...on going

					//pusher notify
					//...on going

					//update and create game
					coin_model.get_coin_at(mysql, active_game.END_DATE,
						function(coin_rate) {
							var data_game = [];
							data_game.push(coin_rate, active_game.GAME_ID);
							game_model.update_sys_game_result(mysql, data_game,
								function(res) {
									console.log('Game at ' + active_game.END_DATE + ' was close!\n');
									//create new game
									create_new_game();
								});
						});
				});
			}
		} else {
			console.log('There\'s no active system game!');
		}
	});
};
var yn_game_schedule = function() {
	game_model.get_active_yn_games(mysql)
		.then((games) => {
			games.forEach((game) => {
				//date for scheduler
				var date_schedule = new Date(game.END_DATE);
				date_schedule.setSeconds(date_schedule.getSeconds() + 1);
				//schedule
				schedule.scheduleJob(date_schedule, function() {
					yn_award_users(mysql, game);
				});
			});
		});
	//listen to new game
	//... on going
};
/*=====END======function for schedule============*/


var sys_game_job = schedule.scheduleJob('1 0 0 * * *', sys_game_schedule);
module.exports = {
	sys_game_controller_running: sys_game_job,
	yn_game_controller_running: yn_game_schedule,
}