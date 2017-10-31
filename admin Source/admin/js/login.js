var login = (function () {

	var inputID = {

		'username': 'Tên tài khoản',
		'password': 'Mật khẩu',
		'emptyInputMessage': {
			'username': 'Tên tài khoản không được trống',
			'password': 'Mật khẩu không được trống',
		}		

	};

	var validFormat = {

		'username': '^.{6,25}$',

	};	

	var invalidFormatMessage = {

		'username': 'Tên tài khoản phải nhiều hơn 6 và ít hơn 25 ký tự',

	};

	var inputs = function () {
		return ['input#username', 'input#password']; // format: selector#id-name
	};	

	return {

		inputs: inputs(),
		inputID: inputID,
		validFormat: validFormat,
		panel: '#login',
		invalidFormatMessage: invalidFormatMessage,

	};

})();