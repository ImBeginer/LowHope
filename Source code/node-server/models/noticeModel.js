"use strict"
var q = require('q'),
    mysql = require('./../models/db.js'),
    moment = require('moment');
class noticeModel {
	add_notice_of_sys_game(winners, game_id){
		let d = q.defer(),
			query = 'INSERT INTO NOTIFICATION_DETAILS (NOTICE_ID,USER_ID,GAME_ID,TYPE_ID,SEND_DATE) VALUES ?',
			notice_data = [];
		winners.forEach((winner, index)=>{
			notice_data.push([
				index + 1,
				winner.USER_ID,
				game_id,
				3,
				moment().format('YYYY-MM-DD HH:mm:ss')
			]);
		});
		mysql.query(query, [notice_data], function(err, res){
			if(err) throw err;
			d.resolve(res);
		})
		return d.promise;
	}
	pusher_notice_sys_game(game_id){
		var d = q.defer();
		var query = 'SELECT n.NOTICE_ID, d.USER_ID, n.TITLE, n.CONTENT, '
		           +'d.SEND_DATE, d.SEEN, g.GAME_ID, d.TYPE_ID, '
		           +'g.START_DATE, g.END_DATE '
		           +'FROM NOTIFICATION n '
		           +'join NOTIFICATION_DETAILS d on n.NOTICE_ID=d.NOTICE_ID '
		           +'join SYSTEM_GAMES g on g.GAME_ID=d.GAME_ID '
				   +'where d.TYPE_ID=3 AND g.GAME_ID = ?;'
		mysql.query(query, [game_id], function(err, res){
        	if(err) throw err;
        	let data = JSON.parse(JSON.stringify(res));
        	d.resolve(data);
        });
        return d.promise;
	}
	add_notice_of_game(notice_id, game_id , game_type, data_input){
		let d = q.defer(),
		    data_insert = [];
		let query = 'INSERT INTO NOTIFICATION_DETAILS (NOTICE_ID,USER_ID,GAME_ID,TYPE_ID,SEND_DATE) VALUES ?';
		if(data_input!=null){
			data_input.forEach((item) => {
				data_insert.push([notice_id, item.USER_ID, game_id, game_type, moment().format("YYYY-MM-DD HH:mm:ss")]);
			});
		}
		else
			d.reject('4th parameter must be array for add_notice_yn_game function!\n');
		mysql.query(query, [data_insert], function(err, res){
			if(err) throw err;
			d.resolve(res);
		});
		return d.promise;
	}
	pusher_notice_yn_game(game_id){
		let d = q.defer(),
			query = 'SELECT n.NOTICE_ID, d.USER_ID, n.TITLE, n.CONTENT, '
	               +'d.SEND_DATE, d.SEEN, g.GAME_ID, d.TYPE_ID, '
                   +'g.START_DATE, g.END_DATE '
                   +'FROM NOTIFICATION n '
                   +'join NOTIFICATION_DETAILS d on n.NOTICE_ID=d.NOTICE_ID '
                   +'join YN_GAMES g on g.GAME_ID=d.GAME_ID '
                   +'where d.TYPE_ID=1 AND g.GAME_ID = ?';
        mysql.query(query, [game_id], function(err, res){
        	if(err) throw err;
        	let data = JSON.parse(JSON.stringify(res));
        	d.resolve(data);
        });
        return d.promise;
	}
	pusher_notice_multi_game(game_id) {
		let d = q.defer(),
			query = 'SELECT n.NOTICE_ID, d.USER_ID, n.TITLE, n.CONTENT, '
	               +'d.SEND_DATE, d.SEEN, g.GAME_ID, d.TYPE_ID, '
                   +'g.START_DATE, g.END_DATE '
                   +'FROM NOTIFICATION n '
                   +'join NOTIFICATION_DETAILS d on n.NOTICE_ID=d.NOTICE_ID '
                   +'join MULTI_CHOICE_GAMES g on g.GAME_ID=d.GAME_ID '
                   +'where d.TYPE_ID=2 AND g.GAME_ID = ?';
        mysql.query(query, [game_id], function(err, res){
        	if(err) throw err;
        	let data = JSON.parse(JSON.stringify(res));
        	d.resolve(data);
        });
        return d.promise;
	}
	add_notice_new_opened_sys_game(game_id){
		let d = q.defer(),
			user_query = 'SELECT USER_ID FROM USERS',
			notice_query = 'INSERT INTO NOTIFICATION_DETAILS (NOTICE_ID,USER_ID,GAME_ID,TYPE_ID,SEND_DATE) VALUES ?',
			notice_data = [];
		mysql.query(user_query, (err, res) => {
			if(err) throw err;
			let users = JSON.parse(JSON.stringify(res));
			users.forEach((user) =>{
				notice_data.push([4, user.USER_ID, game_id, 3, moment().format('YYYY-MM-DD HH:mm:ss')]);
			});
			mysql.query(notice_query, [notice_data], function(err, res){
				if(err) throw err;
				//time_add to select notice
				d.resolve(game_id);
			});
		});
		return d.promise; 
	}
/* 	pusher_new_opened_sys_game(){
		let d = q.defer(),
			query = 'SELECT n.NOTICE_ID, d.USER_ID, n.TITLE, n.CONTENT, ' 
					+'d.SEND_DATE, d.SEEN, d.TYPE_ID '
					+'FROM NOTIFICATION n '
					+'join NOTIFICATION_DETAILS d on n.NOTICE_ID=d.NOTICE_ID '
					+'where d.TYPE_ID=3 AND d.SEND_DATE=?';
		mysql.query(query, [date], function(err, res){
			if(err) throw err;
			let data = JSON.parse(JSON.stringify(res));
			d.resolve(data);
		});
		return d.promise;
	} */
}

module.exports = noticeModel;