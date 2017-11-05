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
		var query = 'call get_sys_game_players(?)';
		connection.query(query, date, function(err, res) {
			if (err) throw err;
			var data = JSON.parse(JSON.stringify(res));
			if (data[0].length === 0) {
				return callback('Data is not available at ' + date)
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
	award_user(connection, data, callback) {
		var query = 'INSERT INTO ACHIEVEMENT SET ?';
		connection.query(query, data, function(err, result) {
			if (err) throw err;
			return callback(result);
		});
	}
}
module.exports = gameModel;