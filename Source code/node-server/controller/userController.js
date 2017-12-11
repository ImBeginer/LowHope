var user_model = new(require('./../models/userModel.js'))(),
	schedule = require('node-schedule');
class UserController{
	reset_user_attendance(){
		schedule.scheduleJob('59 59 23 * * *', function() {
			user_model.reset_attendance()
			.then((res)=>{
				console.log('*(SYSTEM) Reset user attendance!\n');
			})
			.catch((err)=>{
				console.log(err);
			});
		})
	}
}
module.exports = UserController;