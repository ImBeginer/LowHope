var forgotPass = (function () {

	var inputID = {

		'fgnewpass': 'Mật khẩu mới',
		'fgconfirmpass': 'Xác nhận mật khẩu',
		'fgconfirmcode': 'Mã xác nhận',
		'emptyInputMessage': {
			'fgnewpass': 'Mật khẩu mới không được trống',
			'fgconfirmpass': 'Xác nhận mật khẩu không được trống',
			'fgconfirmcode': 'Mã xác nhận không được trống',
		}
	};

	var validFormat = {

		'fgnewpass': '^.{6,20}$',
		'fgconfirmpass': '^.{6,20}$',
		'fgconfirmcode': '^.{6,20}$',

	};	

	var invalidFormatMessage = {

		'fgnewpass': 'Mật khẩu cũ phải nhiều hơn 6 và ít hơn 20 ký tự',
		'fgconfirmpass': 'Mật khẩu mới phải nhiều hơn 6 và ít hơn 20 ký tự',
		'fgconfirmcode': 'Mật khẩu xác nhận phải nhiều hơn 6 và ít hơn 20 ký tự',

	};

	var inputs = function () {
		return ['input#fgnewpass', 'input#fgconfirmpass', 'input#fgconfirmcode'];
	};

	var confirmpass = function () {
		return ['input#fgnewpass', 'input#fgconfirmpass'];
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