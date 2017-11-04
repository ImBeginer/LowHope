var mulGame = (function () {

	var inputID = {
		'game-title-mul': 'Tên game',
		'game-date-mul': 'Ngày kết thúc',
		'game-time-mul': 'Thời gian kết thúc',
		'game-bitcoin-price-upper': 'Giá bitcoin trên khoảng',
		'game-bitcoin-price-lower': 'Giá bitcoin dưới khoảng',

		'emptyInputMessage': {
			'game-title-mul': 'Tên game không được trống',
			'game-date-mul': 'Ngày kết thúc không được trống',
			'game-time-mul': 'Thời gian kết thúc không được trống',
			'game-bitcoin-price-upper': 'Giá bitcoin trên khoảng không được trống',
			'game-bitcoin-price-lower': 'Giá bitcoin dưới khoảng không được trống'
		}		
	};

	var validFormat = {

		'game-title-mul': '^.{6,35}$',
		'game-date-mul': '^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$',
		'game-bitcoin-price-upper': '^\\d{1,10}$',
		'game-bitcoin-price-lower': '^\\d{1,10}$'

	};

	var invalidFormatMessage = {

		'game-title-mul': 'Tên game phải chứa từ 6 đến 35 ký tự',
		'game-date-mul': 'Ơ cái đ*t ngày kết thúc sai rồi @.@',
		'game-bitcoin-price-upper': 'Giá bitcoin trên khoảng phải trên 1 triệu và dưới 1 tỷ VNĐ',
		'game-bitcoin-price-lower': 'Giá bitcoin dưới khoảng phải trên 1 triệu và dưới 1 tỷ VNĐ',

	};	

	var priceInput = function () {
		return ['#game-bitcoin-price-upper', '#game-bitcoin-price-lower'];
	}

	var inputs = function () {
		return ['input#game-title-mul', 'input#game-date-mul', 'input#game-time-mul', 'input#game-bitcoin-price-upper', 'input#game-bitcoin-price-lower'];
	};

	return {
		inputs: inputs(),
		inputID: inputID,
		priceInput: priceInput(),
		validFormat: validFormat,
		panel: 'div#manager-create-game div#multi-choice-game',
		invalidFormatMessage: invalidFormatMessage
	};

})();