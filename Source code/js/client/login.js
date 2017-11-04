var login = (function () {

	var inputID = {

		'username': 'Tài khoản email',
		'userpassword': 'Mật khẩu',

	};

	var validFormat = {

		'username': '^(([^<>()\\[\\]\\\.,;:\\s@"]+(\\.[^<>()\\[\\]\\\.,;:\\s@"]+)*)|(".+"))@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\])|(([a-zA-Z\\-0-9]+\\.)+[a-zA-Z]{2,}))$',
		'userpassword': '^.{6,25}$',

	};

	var invalidFormatMessage = {

		'username': 'Tài khoản email không đúng',
		'userpassword': 'Mật khẩu phải chứa từ 6 đến 25 ký tự',

	};	

	var inputs = function () {
		return ['input#username', 'input#userpassword'];
	};

	return {
		inputs: inputs(),
		inputID: inputID,
		validFormat: validFormat,
		panel: 'div#user-login-panel',
		invalidFormatMessage: invalidFormatMessage
	};	

})();