var forgotPass = (function () {

	var inputID = {

		'userpass': 'Mật khẩu mới',
		'confirmpass': 'Mật khẩu xác nhận ',
		'confirmcode': 'Mã xác nhận',

	};

	var validFormat = {

		'userpass': '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d.*)(?=.*\\W.*)[a-zA-Z0-9\\S]{8,15}$',
		'confirmpass': '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d.*)(?=.*\\W.*)[a-zA-Z0-9\\S]{8,15}$',
		'confirmcode': '^.{8}$'

	};

	var invalidFormatMessage = {

		'userpass': 'Mật khẩu phải chứa từ 8 đến 15 ký tự. Ít nhất 1 chữ hoa, 1 chữ thường, 1 số, 1 kí tự đặc biệt và không có khoảng trắng.',
		'confirmpass': 'Mật khẩu phải chứa từ 8 đến 15 ký tự. Ít nhất 1 chữ hoa, 1 chữ thường, 1 số, 1 kí tự đặc biệt và không có khoảng trắng.',
		'confirmcode': 'Mã xác nhận không hợp lệ',

	};	

	var confirmpass = function () {
		return ['input#userpass', 'input#confirmpass'];
	}

	var inputs = function () {
		return ['input#userpass', 'input#confirmpass', 'input#confirmcode'];
	};

	return {
		inputs: inputs(),
		confirmpass: confirmpass(),
		inputID: inputID,
		validFormat: validFormat,
		panel: 'div#user-login-panel',
		invalidFormatMessage: invalidFormatMessage
	};	

})();