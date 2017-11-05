var game_model = new(require('./../models/gameModel.js'))(),
	coin_model = new(require('./../models/coinModel.js'))(),
	mysql_connection = require('./../models/db.js'),
	moment = require('moment'),
	schedule = require('node-schedule');

/*=====START=====Additional function============*/
function find_winners(date, callback) {
	game_model.get_guess_onactive(mysql_connection, date, function(data) {
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
		PRICE_BET: 15,
		CUR_TYPE_ID: 1
	}

	game_model.create_new_system_game(mysql_connection, data, function(res) {
		console.log('New game is opened!\n');
	});
};
/*=====END=======Additional function============*/
/*=====START======function for schedule============*/
var sys_game_schedule = function() {
	// get active game
	game_model.get_active_sys_game(mysql_connection, function(active_game) {
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
						game_model.award_user(mysql_connection, data, function(res) {
							console.log(winner.USER_NAME + ' was awarded!\n');
						})

					});

					//notification

					//push to client

					console.log(winners);

					//update and create game
					coin_model.get_coin_at(mysql_connection, active_game.END_DATE,
						function(coin_rate) {
							var data_game = [];
							data_game.push(coin_rate, active_game.GAME_ID);
							game_model.update_sys_game_result(mysql_connection, data_game,
								function(res) {
									console.log('Game at ' + active_game.END_DATE + ' was close!\n');
									//create new game
									create_new_game();
								});
						});
				});
			}
		}
	});
};

/*=====END======function for schedule============*/


var sys_game_job = schedule.scheduleJob('1 0 0 * * *', sys_game_schedule);
module.exports = {
	sys_game_controller_running: sys_game_job
}