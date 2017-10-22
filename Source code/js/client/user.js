var user = (function () {

	var inputID = {

		'username': 'Họ tên',
		'userphone': 'Số điện thoại',
		'useraddress': 'Địa chỉ'

	};

	var validFormat = {

		'username': '^.{6,25}$',
		'userphone': '^(\\+84|0)\\d{9,10}$',
		'useraddress': '^.{10,40}$',

	};

	var invalidFormatMessage = {

		'username': 'Họ tên phải chứa từ 6 đến 25 ký tự',
		'userphone': 'Số điện thoại phải có định dạng +84123456789',
		'useraddress': 'Địa chỉ chứa từ 10 đến 40 ký tự',

	};

	var inputs = function () {
		return ['input#username', 'input#userphone', 'input#useraddress'];
	};

	function User (username = '', userphone = '', useraddress = '') {

		this.username = username;
		this.userphone = userphone;
		this.useraddress = useraddress;

	}

	return {
		User: User,
		inputs: inputs(),
		inputID: inputID,
		validFormat: validFormat,
		panel: 'div#user-update-info',
		invalidFormatMessage: invalidFormatMessage
	};

})();
