var Pusher = require('pusher'),
	pusher = new Pusher({
		appId: '416493',
		key: '802fc577223f4567a8df',
		secret: '251f06b4c247f87f7593',
		cluster: 'ap1',
		encrypted: true
	});
module.exports = pusher;