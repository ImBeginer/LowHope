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
		'username':'^(([^<>()\\[\\]\\\.,;:\\s@"]+(\\.[^<>()\\[\\]\\\.,;:\\s@"]+)*)|(".+"))@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\])|(([a-zA-Z\\-0-9]+\\.)+[a-zA-Z]{2,}))$',
		// 'username': '^.{6,25}$',
		'password' : '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d.*)(?=.*\\W.*)[a-zA-Z0-9\\S]{8,15}$',
		//Strong passwords with min 8 - max 15 character length, at least one uppercase letter, one lowercase letter, one number, one special character (all, not just defined), space is not allowed.

	};	

	var invalidFormatMessage = {

		'username': 'Vui lòng nhập đúng email',
		'password': 'Mật khẩu phải có độ dài từ 8 tới 12 kí tự, chứa ít nhất một chữ cái thường, một chữ hoa, một số, một kí tự đặc biệt và không chứa khoảng trắng',

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