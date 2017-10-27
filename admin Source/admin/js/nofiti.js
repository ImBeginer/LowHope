var notifi = (function () {

	function Notifi (message = '', sendType = -1) {
		this.message = message;
		this.sendType = sendType;
	}

	var inputID = {

		'notifi-panel': 'Tin nhắn',
		'notifi-ratio': 'Phương thức gửi thông báo',
		'mail-ratio': 'Phương thức gửi mail',
		'both-ratio': 'Cả 2 phương thức gửi thông báo và mail',
		'emptyInputMessage': {
			'notifi-panel': 'Tin nhắn gửi đi không được trống',
			'notifi-ratio': 'Bạn phải lựa chọn phương thức gửi thông báo',
			'mail-ratio': 'Bạn phải lựa chọn phương thức gửi thông báo',
			'both-ratio': 'Bạn phải lựa chọn phương thức gửi thông báo',		
		}
	};

	var validFormat = {

		'notifi-panel': '^.{50,150}$',

	};	

	var invalidFormatMessage = {

		'notifi-panel': 'Tin nhắn phải nhiều hơn 50 và ít hơn 150 ký tự',

	};

	var inputs = function () {
		return ['textarea#notifi-panel', 'input#notifi-radio', 'input#mail-radio', 'input#both-radio'];
	};

	return {

		Notifi: Notifi,
		inputs: inputs(),
		inputID: inputID,
		validFormat: validFormat,
		panel: '#user-notifi-send-panel',
		invalidFormatMessage: invalidFormatMessage,

	};

})();