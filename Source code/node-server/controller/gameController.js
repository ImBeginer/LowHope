var game_model = new(require('./../models/gameModel.js'))(),
	coin_model = new(require('./../models/coinModel.js'))(),
	user_model = new(require('./../models/userModel.js'))(),
	notice_model = new(require('./../models/noticeModel.js'))(),
	moment = require('moment'),
	q = require('q'),
	pusher = require('./../third-partyservice/pusher.js'),
	schedule = require('node-schedule');
/*=====START=====Additional functions============*/
function find_winners(date) {
	let d = q.defer();
	game_model.get_guess_onactive(date)
	.then((data)=>{
		if (data.constructor === Array) {
			var winners = [];
			if (data.length === 1) {
				winners.push(data[0]);
			} else if (data.length === 2) {
				winners.push(data[0], data[1]);
			} else {
				winners.push(data[0], data[1], data[2]);
			}
			d.resolve(winners);
		} else {
			d.reject(data);
		}
	})
	.catch((err)=>{
		d.reject(err);
	});
	return d.promise;
};

function create_new_game() {
	let d = q.defer();
	    start_date = moment().format('YYYY-MM-DD HH:mm:ss'),
		end_date = moment().add(7, 'days').format('YYYY-MM-DD')
	    data = {
			TITLE: "Có ngon vào thử",
			CONTENT: "Giá bitcoin ngày " 
			         + moment(end_date).format('DD-MM-YYYY') + " vào lúc " + moment(end_date).format('HH:mm:ss'),
			START_DATE: start_date,
			END_DATE: end_date,
			ACTIVE: 1,
			POINT_TO_BET: 100,
			CUR_TYPE_ID: 1
	    };

	game_model.create_new_system_game(data)
	.then((game_id)=>{
		console.log('*(SYSTEM_GAME) New game is opened!\n');
		d.resolve(game_id);
	});
	return d.promise;
};

var sys_game_schedule = function() {
	// get active game
	game_model.get_active_sys_game()
	.then((active_game)=>{
		if(active_game!=null){
			var end_date = moment(active_game.END_DATE).format("YYYY-MM-DD");
			var isDeadline = end_date == moment().format("YYYY-MM-DD");
			if(isDeadline){
				find_winners(active_game.END_DATE)
				.then((winners)=>{
					//award users
					game_model.sys_award_users(winners, active_game.GAME_ID)
					.then(() => console.log('*(SYSTEM_GAME)Users was awarded in system game ended at ' 
											 + active_game.END_DATE + '\n'));
					
					//add notice and push to user
					notice_model.add_notice_of_sys_game(winners, active_game.GAME_ID)
					.then(() => {
						return notice_model.pusher_notice_sys_game(active_game.GAME_ID)
					})
					.then(notice =>{
						pusher.trigger('system-game', 'pop-winners', notice);
						console.log('*(SYSTEM_GAME) Annouced result to clients: ok!\n');
					});

					//update game result and create the new game
					game_model.update_sys_game_result([winners[0].result, active_game.GAME_ID])
					.then(()=>{
						console.log('*(SYSTEM_GAME)Game at ' + active_game.END_DATE + ' closed!\n');
						//create new game
						return create_new_game();
					})
					.then(game_id => {
						//announce new opened system game
						return notice_model.add_notice_new_opened_sys_game(game_id);
					})
					.then(game_id => { return notice_model.pusher_notice_sys_game(game_id) })
					.then(notice => {
						pusher.trigger('system-game', 'pop-users', notice);
						console.log('*(SYSTEM_GAME)Announced new opened system game!\n');
					});
				})
				.catch(err => console.log(err));
			}
			else{
				console.log('*(SYSTEM_GAME)Today is not the end of system game!\n');
			}
		}
		else
			console.log('There\'s no active system game!');
	});
};

function yn_award_users(game) {
	game_model.get_yn_game_players([game.END_DATE, game.GAME_ID])
	.then(data=>{
		//award users
		user_model.update_winners_points(data.winners)
		.then((total_spend)=>{
			return user_model.update_user_points([(data.owner.USER_POINT+(game.TOTAL_AMOUNT-total_spend)),data.owner.OWNER_ID]);
		})
		.then(res => game_model.update_yn_game_result([data.winners[0].RESULT, game.GAME_ID]))
		.then(res => console.log('*(YN_GAMES)Game id: ' + game.GAME_ID + ' closed!\n*Winners id awarded!\n'))
		.catch(err=> console.log(err));

		//update user result in logs
		game_model.yn_update_users_result(data.winners, game.GAME_ID, 1)
		.then(()=>{ return game_model.yn_update_users_result(data.loosers, game.GAME_ID, 0) })
		.then(()=> console.log('*(YN_GAMES)User result updated to game yn logs, id: ' + game.GAME_ID + '\n'));

		//add notice and push to client
		notice_model.add_notice_of_game(5, game.GAME_ID, 1,data.winners)
		.then(()=> {
			return notice_model.add_notice_of_game(6, game.GAME_ID, 1,data.loosers);
		})
		.then(()=> {
			console.log('*(YN_GAMES)Add notice for winners and loosers: ok\n');
			return notice_model.pusher_notice_yn_game(game.GAME_ID);
		})
		.then((notice) => {
			pusher.trigger('yn-game', 'pop-players', notice);
			console.log('*(YN_GAME)Pusher to client: ok!\n');
		});
	});
};

function multi_award_users(game){
	game_model.get_multi_game_players([game.END_DATE, game.GAME_ID])
	.then((data) =>{
		//award users
		user_model.update_winners_points(data.winners)
		.then(total_spend => {
			return user_model.update_user_points([(data.owner.USER_POINT+(game.TOTAL_AMOUNT-total_spend)),
				                                   data.owner.OWNER_ID]);
		})
		.then(res => game_model.update_multi_game_result([data.winners[0].RESULT, game.GAME_ID]))
		.then(res => console.log('*(MULTI_CHOICE_GAMES)Game id: ' + game.GAME_ID + ' closed!\n*Winners id awarded!\n'))
		.catch(err=> console.log(err));

		//update user result in logs
		game_model.multi_game_update_users_result(data.winners, game.GAME_ID, 1)
		.then(()=>{ return game_model.multi_game_update_users_result(data.loosers, game.GAME_ID, 0) })
		.then(()=> console.log('*(MULTI_CHOICE_GAMES)User result updated to game yn logs, id: ' + game.GAME_ID + '\n'));

		//add notice and push to client
		notice_model.add_notice_of_game(5, game.GAME_ID, 2,data.winners)
		.then(()=> {
			return notice_model.add_notice_of_game(6, game.GAME_ID, 2,data.loosers);
		})
		.then(()=> {
			console.log('*(MULTI_CHOICE_GAMES)Add notice for winners and loosers: ok\n');
			return notice_model.pusher_notice_multi_game(game.GAME_ID);
		})
		.then(notice =>{
			pusher.trigger('multi-game', 'pop-players', notice);
			console.log('*(MULTI_CHOICE_GAMES) Pusher to client: ok!\n');
		})

	});
}

/*=====END=======Additional functions============*/

//schedule system game
var sys_game_job = schedule.scheduleJob('2 0 0 * * *', sys_game_schedule);

//schedule yn games
let yn_game_schedule = function() {
	game_model.get_active_yn_games()
	.then((games) => {
		games.forEach((game) => {
			//date for scheduler
			let date_schedule = new Date(game.END_DATE);
			date_schedule.setSeconds(date_schedule.getSeconds() + 1);
			//schedule
			schedule.scheduleJob(date_schedule, function() {
				yn_award_users(game);
			});
		});
	});
};

//schedule multi games
let multi_game_schedule = function(){
	game_model.get_active_multi_games()
	.then((games) =>{
		games.forEach((game) => {
			let date_schedule = new Date(game.END_DATE);
			date_schedule.setSeconds(date_schedule.getSeconds() + 1);
			//schedule
			schedule.scheduleJob(date_schedule, function() {
				multi_award_users(game);
			});
		});
	})
}

module.exports = {
	sys_game_controller_running: function() {
		sys_game_job
	},
	yn_game_controller_running: yn_game_schedule,
	multi_game_controller_running: multi_game_schedule,
	yn_award_users:yn_award_users,
	multi_award_users:multi_award_users,
	//temp
	sys_game_schedule:sys_game_schedule
}