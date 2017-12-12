var password = (function () {

	var inputID = {

		'oldpass': 'Mật khẩu cũ',
		'newpass': 'Mật khẩu mới',
		'confirmpass': 'Nhập lại mật khẩu',
		'emptyInputMessage': {
			'oldpass': 'Mật khẩu không được để trống',
			'newpass': 'Mật khẩu không được để trống',
			'confirmpass': 'Mật khẩu không được để trống',
		}
	};

	var validFormat = {

		'oldpass': '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d.*)(?=.*\\W.*)[a-zA-Z0-9\\S]{8,15}$',
		'newpass': '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d.*)(?=.*\\W.*)[a-zA-Z0-9\\S]{8,15}$',
		'confirmpass': '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d.*)(?=.*\\W.*)[a-zA-Z0-9\\S]{8,15}$',

	};	

	var invalidFormatMessage = {

		'oldpass': 'Mật khẩu phải có độ dài từ 8 tới 12 kí tự, chứa ít nhất một chữ cái thường, một chữ hoa, một số, một kí tự đặc biệt và không chứa khoảng trắng',
		'newpass': 'Mật khẩu phải có độ dài từ 8 tới 12 kí tự, chứa ít nhất một chữ cái thường, một chữ hoa, một số, một kí tự đặc biệt và không chứa khoảng trắng',
		'confirmpass': 'Mật khẩu phải có độ dài từ 8 tới 12 kí tự, chứa ít nhất một chữ cái thường, một chữ hoa, một số, một kí tự đặc biệt và không chứa khoảng trắng',

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