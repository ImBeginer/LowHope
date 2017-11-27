"use strict"
var q = require('q'),
    mysql = require('./../models/db.js');
class coinModel {
	insertCoinRate(data) {
		let d = q.defer();
		var query = 'INSERT INTO CURRENCY_DETAILS SET ?';
		data['type_id'] = 1;
		mysql.query(query, data, function(err, result) {
			if (err) d.reject(new Error(err));
			d.resolve(result);
		});
		return d.promise;
	}
	getCoinRate() {
		let d = q.defer();
		var query = 'SELECT (unix_timestamp(UPDATE_AT)*1000) as x, round(PRICE,2) as y FROM CURRENCY_DETAILS';
		mysql.query(query, function(err, result) {
			if (err) d.reject(new Error(err));
			d.resolve(result);
		});
		return d.promise;
	}
	get_coin_at(date) {
		let d = q.defer();
		var query = 'select round(PRICE,2) as PRICE from CURRENCY_DETAILS where UPDATE_AT = ?';
		mysql.query(query, date, function(err, result) {
			if (err) d.reject(err);
			var data = JSON.parse(JSON.stringify(result))[0].PRICE;
			d.resolve(data);
		});
		return d.promise;
	}
}

module.exports = coinModel;