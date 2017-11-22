var login = (function () {

	var inputID = {

		'username': 'Tài khoản email',
		'userpassword': 'Mật khẩu',

	};

	var validFormat = {

		'username': '^(([^<>()\\[\\]\\\.,;:\\s@"]+(\\.[^<>()\\[\\]\\\.,;:\\s@"]+)*)|(".+"))@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\])|(([a-zA-Z\\-0-9]+\\.)+[a-zA-Z]{2,}))$',
		'userpassword': '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d.*)(?=.*\\W.*)[a-zA-Z0-9\\S]{8,15}$',

	};

	var invalidFormatMessage = {
		'username': 'Tài khoản email không đúng',
		'userpassword': 'Mật khẩu phải chứa từ 8 đến 15 ký tự. Ít nhất 1 chữ hoa, 1 chữ thường, 1 số, 1 kí tự đặc biệt và không có khoảng trắng.',
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