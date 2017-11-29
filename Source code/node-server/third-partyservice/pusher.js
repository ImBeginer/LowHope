var Pusher = require('pusher');
var pusher = new Pusher({
	appId: '435007',
	key: 'df4ed713f2f76fde17d4',
	secret: 'd2480ef6be7773efb2d0',
	cluster: 'ap1',
	encrypted: true
});
module.exports = pusher;