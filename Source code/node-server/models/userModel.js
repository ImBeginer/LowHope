var q = require('q'),
	mysql = require('./../models/db.js'),
	async = require('async');
class userModel {
	get_user_point(dataInput) {
		var d = q.defer();
		var query = 'SELECT USER_POINT FROM USERS WHERE USER_ID = ?';
		mysql.query(query, dataInput, function(err, res) {
			if (err) d.reject(err);
			var data = JSON.parse(JSON.stringify(res))[0];
			d.resolve(data.USER_POINT);
		});
		return d.promise;
	}
	update_user_points(dataInput) {
		var d = q.defer();
		var query = 'UPDATE USERS SET USER_POINT = ? WHERE USER_ID = ?';
		mysql.query(query, dataInput, function(err, res) {
			if (err) throw err;
			d.resolve('ok');
		});
		return d.promise;
	}
	update_winners_points(dataInput) {
		var d = q.defer();
		var query = 'UPDATE USERS SET USER_POINT = ? WHERE USER_ID = ?; ';
		var queries = '';
		let total_spend = 0;
		if(dataInput.length != 0){
			for(var i = 0; i< dataInput.length; i++){
				queries += mysql.format(query, [dataInput[i].USER_POINT + 20, dataInput[i].USER_ID]);
				total_spend+=20;
			}
			mysql.query(queries, function(err, res){
				if(err) throw err;
			});
		}
		d.resolve(total_spend);
		return d.promise;
	}
	reset_attendance(){
		let d = q.defer();
		var query = 'UPDATE USERS SET ATTENDANCE=0, DAILYGAME_CHECKOUT=0 WHERE USER_ID>0;';
		mysql.query(query, function(err, result){
			if(err) d.reject(err);
			d.resolve(result);
 		});
		return d.promise;
	}
}
module.exports = userModel;