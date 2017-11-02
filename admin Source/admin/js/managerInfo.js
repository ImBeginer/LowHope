var managerInfo = (function () {

	var inputID = {

		'm-name': 'Họ tên',
		'm-phone': 'Số điện thoại',
		'm-address': 'Địa chỉ',
		'm-email': 'Email',
		'emptyInputMessage': {
			'm-name': 'Họ tên không được trống',
			'm-phone': 'Số điện thoại không được trống',
			'm-address': 'Địa chỉ không được trống',
			'm-email': 'Email không được trống',			
		}
	};

	var validFormat = {

		'm-name': '^.{6,25}$',
		'm-phone': '^(\\+84|0)\\d{9,10}$',
		'm-address': '^.{10,40}$',
		'm-email': '^(([^<>()\\[\\]\\\.,;:\\s@"]+(\\.[^<>()\\[\\]\\\.,;:\\s@"]+)*)|(".+"))@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\])|(([a-zA-Z\\-0-9]+\\.)+[a-zA-Z]{2,}))$',

	};	

	var invalidFormatMessage = {

		'm-name': 'Họ tên phải nhiều hơn 6 và ít hơn 25 ký tự',
		'm-phone': 'Số điện thoại phải có dạng +84123456789',
		'm-address': 'Địa chỉ phải nhiều hơn 10 và ít hơn 40 ký tự',
		'm-email': 'Email không chính xác',	
	};

	var inputs = function () {
		return ['input#m-name', 'input#m-phone', 'input#m-address', 'input#m-email'];
	};

	return {

		inputs: inputs(),
		inputID: inputID,
		validFormat: validFormat,
		panel: '#manager-info-edit',
		invalidFormatMessage: invalidFormatMessage,

	};	


})();