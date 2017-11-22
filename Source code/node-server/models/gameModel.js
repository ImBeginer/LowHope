var q = require('q'),
	d = q.defer();
class gameModel {
	get_active_sys_game(connection, callback) {
		var query = 'SELECT GAME_ID, END_DATE FROM SYSTEM_GAMES WHERE ACTIVE = 1';
		connection.query(query, function(err, res) {
			if (err) throw err;
			var data = JSON.parse(JSON.stringify(res))[0];
			return callback(data);
		});
	}
	get_guess_onactive(connection, date, callback) {
		var query = 'call GET_SYS_GAME_PLAYERS(?)';
		connection.query(query, date, function(err, res) {
			if (err) throw err;
			var data = JSON.parse(JSON.stringify(res));
			if (data[0].length === 0) {
				return callback('Bitcoin rate is not available at ' + date)
			}
			return callback(data[1]);
		});
	}
	update_sys_game_result(connection, data, callback) {
		var query = 'UPDATE SYSTEM_GAMES SET ACTIVE = 0, RESULT = ? WHERE GAME_ID = ?';
		connection.query(query, data, function(err, res) {
			if (err) throw err;
			return callback(res);
		});
	}
	create_new_system_game(connection, data, callback) {
		var query = 'INSERT INTO SYSTEM_GAMES SET ?';
		connection.query(query, data, function(err, result) {
			if (err) throw err;
			return callback(result);
		});
	}
	sys_award_user(connection, data, callback) {
		var query = 'INSERT INTO ACHIEVEMENT SET ?';
		connection.query(query, data, function(err, result) {
			if (err) throw err;
			return callback(result);
		});
	}
	get_yn_game_winners(connection, dataInput) {
		var d = q.defer();
		var query = 'call GET_YN_GAME_WINNERS(?,?)';
		connection.query(query, dataInput, function(err, res) {
			if (err) throw err;
			var dataResponse = JSON.parse(JSON.stringify(res));
			if (dataResponse[0].length === 0) {
				d.reject('Bitcoin rate is not available at ' + dataInput[0]);
			}
			d.resolve(dataResponse[1]);
		});
		return d.promise;
	}
	get_active_yn_games(connection) {
		var d = q.defer();
		var query = 'SELECT GAME_ID, date_format(END_DATE, "%Y-%m-%d %H:%i:00") as END_DATE, TOTAL_AMOUNT, OWNER_ID FROM YN_GAMES WHERE ACTIVE = 1';
		connection.query(query, function(err, res) {
			if (err) throw err;
			var games = JSON.parse(JSON.stringify(res));
			d.resolve(games);
		});
		return d.promise;
	}
	update_yn_game_result(connection, data) {
		var d = q.defer();
		var query = 'UPDATE YN_GAMES SET ACTIVE = 0, RESULT = ? WHERE GAME_ID = ?';
		connection.query(query, data, function(err, res) {
			if (err) throw err;
			d.resolve(res);
		});
		return d.promise;
	}
}
module.exports = gameModel;