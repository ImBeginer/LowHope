var q = require('q'),
	mysql = require('./../models/db.js'),
	async = require('async');
class userModel {
	get_user_point(connection, dataInput) {
		var d = q.defer();
		var query = 'SELECT USER_POINT FROM USERS WHERE USER_ID = ?';
		connection.query(query, dataInput, function(err, res) {
			if (err) d.reject(err);
			var data = JSON.parse(JSON.stringify(res))[0];
			d.resolve(data.USER_POINT);
		});
		return d.promise;
	}
	update_user_points(connection, dataInput) {
		var d = q.defer();
		var query = 'UPDATE USERS SET USER_POINT = ? WHERE USER_ID = ?';
		connection.query(query, dataInput, function(err, res) {
			if (err) d.reject(err);
			d.resolve('ok');
		});
		return d.promise;
	}
	update_users_points(connection, dataInput) {
		var d = q.defer();
		var query = 'UPDATE USERS SET USER_POINT = ? WHERE USER_ID = ?; ';
		var queries = '';
		for(var i = 0; i< dataInput.length; i++){
			queries += mysql.format(query, [dataInput[i].USER_POINT + 20, dataInput[i].USER_ID]);
		}
		connection.query(queries, d.makeNodeResolver());
		return d.promise;
	}
}
module.exports = userModel;