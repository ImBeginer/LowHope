var forgotPass = (function () {

	var inputID = {

		'fgemail': 'Email',
		'emptyInputMessage': {
			'fgemail': 'Email không được trống',
		}
	};

	var validFormat = {

		'fgemail': '^(([^<>()\\[\\]\\\.,;:\\s@"]+(\\.[^<>()\\[\\]\\\.,;:\\s@"]+)*)|(".+"))@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\])|(([a-zA-Z\\-0-9]+\\.)+[a-zA-Z]{2,}))$',

	};	

	var invalidFormatMessage = {

		'fgemail': 'Vui lòng nhập đúng email!',

	};

	var inputs = function () {
		return ['input#fgemail'];
	};

	return {

		inputs: inputs(),
		inputID: inputID,
		validFormat: validFormat,
		panel: '.manager-info',
		invalidFormatMessage: invalidFormatMessage,

	};	


})();