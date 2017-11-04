var forgotPass = (function () {

	var inputID = {

		'userpass': 'Mật khẩu mới',
		'confirmpass': 'Mật khẩu xác nhận ',
		'confirmcode': 'Mã xác nhận',

	};

	var validFormat = {

		'userpass': '^.{6,25}$',
		'confirmpass': '^.{6,25}$',
		'confirmcode': '^.{6}$'

	};

	var invalidFormatMessage = {

		'userpass': 'Mật khẩu mới xác nhận phải chứa từ 6 đến 25 ký tự',
		'confirmpass': 'Mật khẩu xác nhận phải chứa từ 6 đến 25 ký tự',
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