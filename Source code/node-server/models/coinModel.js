"use strict"
class coinModel {
	insertCoinRate(connection, data, callback) {
		var query = 'INSERT INTO CURRENCY_DETAILS SET ?';
		data['type_id'] = 1;
		connection.query(query, data, function(err, result) {
			if (err) throw err;
			return callback(result);
		});
	}
	getCoinRate(connection, callback) {
		var query = 'SELECT (unix_timestamp(UPDATE_AT)*1000) as x, round(PRICE,2) as y FROM CURRENCY_DETAILS coin ';
		//var query = 'SELECT UPDATE_AT as x, round(PRICE,2) as y ' + 'FROM CURRENCY_DETAILS';
		connection.query(query, function(err, result) {
			if (err) throw err;
			return callback(result);
		});
	}
	get_coin_at(connection, date, callback) {
		var query = 'select PRICE from currency_details where UPDATE_AT = ?';
		connection.query(query, date, function(err, result) {
			if (err) throw err;
			var data = JSON.parse(JSON.stringify(result))[0].PRICE;
			return callback(data);
		});
	}
}

module.exports = coinModel;