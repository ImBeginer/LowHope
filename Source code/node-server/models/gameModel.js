var q = require('q'),
	mysql = require('./../models/db.js'),
	moment = require('moment');
class gameModel {
	get_active_sys_game() {
		let d = q.defer();
		let query = 'SELECT GAME_ID, END_DATE FROM SYSTEM_GAMES WHERE ACTIVE = 1';
		mysql.query(query, function(err, res) {
			if (err) throw err;
			let data = JSON.parse(JSON.stringify(res))[0];
			d.resolve(data);
		});
		return d.promise;
	}
	get_guess_onactive(date) {
		let d = q.defer();
		let query = 'call GET_SYS_GAME_PLAYERS(?)';
		mysql.query(query, date, function(err, res) {
			if (err) throw err;
			let data = JSON.parse(JSON.stringify(res));
			if (data[0].length === 0) {
				d.resolve('Bitcoin rate is not available at ' + date);
			}
			d.resolve({
				game_result: data[0][0].game_result,
				winners: data[1]
			});
		});
		return d.promise;
	}
	update_sys_game_result(data) {
		let d = q.defer();
		let query = 'UPDATE SYSTEM_GAMES SET ACTIVE = 0, RESULT = ? WHERE GAME_ID = ?';
		mysql.query(query, data, function(err, res) {
			if (err) throw err;
			d.resolve(res);
		});
		return d.promise;
	}
	create_new_system_game(data) {
		let d = q.defer();
		let query = 'INSERT INTO SYSTEM_GAMES SET ?';
		mysql.query(query, data, function(err, res) {
			if (err) throw err;
			let id_return =  JSON.parse(JSON.stringify(res)).insertId;
			d.resolve(id_return);
		});
		return d.promise;
	}
	sys_get_prizes(){
		let d = q.defer(),
			query = 'SELECT AWARD_ID, PRIZE FROM AWARD where ACTIVE=1 order by PRIZE';
		mysql.query(query, function(err, res){
			if(err) throw err;
			d.resolve(JSON.parse(JSON.stringify(res)));
		});
		return d.promise;
	}
	sys_award_users(winners, game_id) {
		let d = q.defer(),
			query = 'INSERT INTO ACHIEVEMENT (USER_ID,AWARD_ID,GAME_ID,GET_AT) VALUES ?',
			award_data = [],
			prize_data = {};
		this.sys_get_prizes()
		.then(prizes => {
			winners.forEach((winner, index) => {
				award_data.push([
					winner.USER_ID,
					prizes[index].AWARD_ID,
					game_id,
					moment().format('YYYY-MM-DD HH:mm:ss')
				])
			});
			mysql.query(query, [award_data], function (err, result) {
				if (err) throw err;
				d.resolve(result);
			});
		});

		return d.promise;
	}
	get_yn_game_players(dataInput) {
		let d = q.defer();
		let query = 'call GET_YN_GAME_PLAYERS(?,?)';
		mysql.query(query, dataInput, function(err, res) {
			if (err) throw err;
			let data = JSON.parse(JSON.stringify(res));
			if (data[0].length === 0) {
				d.resolve('Bitcoin rate is not available at ' + dataInput[0]);
			}
			d.resolve({
				game_result: data[0][0].game_result,
				winners: data[1],
				loosers: data[2],
				owner: data[3][0]
			});
		});
		return d.promise;
	}
	get_active_yn_games() {
		let d = q.defer();
		let query = 'SELECT GAME_ID, date_format(END_DATE, "%Y-%m-%d %H:%i:00") as END_DATE, OWNER_ID FROM YN_GAMES WHERE ACTIVE = 1';
		mysql.query(query, function(err, res) {
			if (err) throw err;
			let games = JSON.parse(JSON.stringify(res));
			d.resolve(games);
		});
		return d.promise;
	}
	update_yn_game_result(data) {
		let d = q.defer();
		let query = 'UPDATE YN_GAMES SET ACTIVE = 0, RESULT = ? WHERE GAME_ID = ?';
		mysql.query(query, data, function(err, res) {
			if (err) throw err;
			d.resolve(res);
		});
		return d.promise;
	}
	yn_update_users_result(players, game_id, result){
		let d = q.defer(),
			queries = '',
			query = 'UPDATE YN_GAME_LOGS SET IS_WINNER = ? WHERE USER_ID = ? AND GAME_ID = ?; ';
		if(players.length != 0){
			players.forEach((player) =>{
				queries += mysql.format(query, [result, player.USER_ID, game_id]);
			});
			mysql.query(queries, function(err, res){
				if(err) throw err;
				d.resolve('*(YN_GAMES)Update users result: ok!\n');
			});
		}
		else{
			d.resolve('*(YN_GAMES)No data modified!');
		}
		return d.promise;
	}
	get_active_multi_games(){
		let d = q.defer(),
		    query = 'SELECT GAME_ID, date_format(END_DATE, "%Y-%m-%d %H:%i:00") as END_DATE, '
		           +'OWNER_ID FROM MULTI_CHOICE_GAMES WHERE ACTIVE = 1';
		mysql.query(query, function(err, res) {
			if (err) throw err;
			let games = JSON.parse(JSON.stringify(res));
			d.resolve(games);
		});
		return d.promise;
	}
	get_multi_game_players(data_input){
		let d = q.defer();
		let query = 'call GET_MULTI_GAME_PLAYERS(?,?)';
		mysql.query(query, data_input, function(err, res) {
			if (err) throw err;
			let data = JSON.parse(JSON.stringify(res));
			if (data[0].length === 0) {
				d.resolve('Bitcoin rate is not available at ' + data_input[0]);
			}
			d.resolve({
				game_result: data[0][0].game_result,
				winners: data[2],
				loosers: data[3],
				owner: data[4][0]
			});
		});
		return d.promise;
	}
	update_multi_game_result(data){
		let d = q.defer();
		let query = 'UPDATE MULTI_CHOICE_GAMES SET ACTIVE = 0, RESULT = ? WHERE GAME_ID = ?';
		mysql.query(query, data, function(err, res) {
			if (err) throw err;
			d.resolve(res);
		});
		return d.promise;
	}
	multi_game_update_users_result(players, game_id, result) {
		let d = q.defer(),
			queries = '',
			query = 'UPDATE MULTI_CHOICE_GAME_LOGS SET IS_WINNER = ? WHERE USER_ID = ? AND GAME_ID = ?; ';
		if (players.length != 0) {
			players.forEach((player) => {
				queries += mysql.format(query, [result, player.USER_ID, game_id]);
			});
			mysql.query(queries, function(err, res) {
				if (err) throw err;
				d.resolve('(MULTI_CHOICE_GAMES) Update users result: ok!\n');
			});
		}
		else {
			d.resolve('*(MULTI_CHOICE_GAMES)No data modified!');
		}
		return d.promise;
	}
	check_info_yn_game(game_id){
		let d = q.defer(),
			query = 'select ACTIVE, TOTAL_AMOUNT from YN_GAMES where GAME_ID = ?;';
		mysql.query(query, [game_id],function(err, res){
			if (err) throw err;
			d.resolve(JSON.parse(JSON.stringify(res))[0]);
		});
		return d.promise;
	}
	check_info_multi_game(game_id){
		let d = q.defer(),
			query = 'select ACTIVE, TOTAL_AMOUNT from MULTI_CHOICE_GAMES where GAME_ID = ?;';
		mysql.query(query, [game_id],function(err, res){
			if (err) throw err;
			d.resolve(JSON.parse(JSON.stringify(res))[0]);
		});
		return d.promise;
	}
	get_yn_game_by_id(game_id){
		let d = q.defer(),
			query = 'SELECT GAME_ID, START_DATE, date_format(END_DATE, "%Y-%m-%d %H:%i:00") as END_DATE, OWNER_ID FROM YN_GAMES where GAME_ID = ?'
		mysql.query(query, [game_id], function(err, res){
			if (err) throw err;
			let data = JSON.parse(JSON.stringify(res));
			d.resolve(data[0]);
		});
		return d.promise;
	}
	get_multi_game_by_id(game_id){
		let d = q.defer(),
		    query = 'SELECT GAME_ID, START_DATE, date_format(END_DATE, "%Y-%m-%d %H:%i:00") as END_DATE, OWNER_ID FROM MULTI_CHOICE_GAMES where GAME_ID = ?'
		mysql.query(query, [game_id], function (err, res) {
			if (err) throw err;
			let data = JSON.parse(JSON.stringify(res));
			d.resolve(data[0]);
		});
		return d.promise;
	}
	create_chat_channel(game_id, title){
		let d = q.defer();
		let query = 'INSERT INTO CHAT_ROOMS SET ?';
		mysql.query(query, {
			GAME_ID: game_id,
			ROOM_NAME: title,
			CREATE_DATE: moment().format('YYYY-MM-DD HH:mm:ss')
		}, function(err, res) {
			if (err) throw err;
			d.resolve('ok');
		});
		return d.promise;
	}
}
module.exports = gameModel;