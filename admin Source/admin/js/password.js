var password = (function () {

	var inputID = {

		'oldpass': 'Mật khẩu cũ',
		'newpass': 'Mật khẩu mới',
		'confirmpass': 'Nhập lại mật khẩu',
		'emptyInputMessage': {
			'oldpass': 'Mật khẩu cũ không được trống',
			'newpass': 'Mật khẩu mới không được trống',
			'confirmpass': 'Mật khẩu xác nhận không được trống',
		}
	};

	var validFormat = {

		'oldpass': '^.{6,20}$',
		'newpass': '^.{6,20}$',
		'confirmpass': '^.{6,20}$',

	};	

	var invalidFormatMessage = {

		'oldpass': 'Mật khẩu cũ phải nhiều hơn 6 và ít hơn 20 ký tự',
		'newpass': 'Mật khẩu mới phải nhiều hơn 6 và ít hơn 20 ký tự',
		'confirmpass': 'Mật khẩu xác nhận phải nhiều hơn 6 và ít hơn 20 ký tự',

	};

	var inputs = function () {
		return ['input#oldpass', 'input#newpass', 'input#confirmpass'];
	};

	var confirmpass = function () {
		return ['input#newpass', 'input#confirmpass'];
	}

	return {

		inputs: inputs(),
		confirmpass: confirmpass(),
		inputID: inputID,
		validFormat: validFormat,
		panel: '.manager-info',
		invalidFormatMessage: invalidFormatMessage,

	};	

})();