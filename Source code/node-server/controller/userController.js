var user_model = new(require('./../models/userModel.js'))(),
	schedule = require('node-schedule');

module.exports = {
	reset_user_attendance: function(){
		schedule.scheduleJob('59 59 23 * * *', function() {
			user_model.reset_attendance()
			.then((res)=>{
				console.log('reset user attendance!\n');
			})
			.catch((err)=>{
				console.log(err);
			});
		})
	}
}