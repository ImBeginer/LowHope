var mulGame = (function () {

	var inputID = {
		'game-title-mul': 'Tên game',
		'game-date-mul': 'Ngày kết thúc',
		'game-time-mul': 'Thời gian kết thúc',
		'game-bitcoin-price-upper': 'Giá bitcoin trên khoảng',
		'game-bitcoin-price-lower': 'Giá bitcoin dưới khoảng',
	};

	var validFormat = {
		'game-title-mul': '^.{6,}$',
		'game-date-mul': '^(?:(?:31(\\/|-|\\.)(?:0?[13578]|1[02]))\\1|(?:(?:29|30)(\\/|-|\\.)(?:0?[1,3-9]|1[0-2])\\2))(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$|^(?:29(\\/|-|\\.)0?2\\3(?:(?:(?:1[6-9]|[2-9]\\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\\d|2[0-8])(\\/|-|\\.)(?:(?:0?[1-9])|(?:1[0-2]))\\4(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$',
		'game-bitcoin-price-upper': '^\\s*(?=.*[1-9])\\d*(?:[^,;]+\\.\\d{1,2})?\\s*$',
		'game-bitcoin-price-lower': '^\\s*(?=.*[1-9])\\d*(?:[^,;]+\\.\\d{1,2})?\\s*$',
	};

	var invalidFormatMessage = {
		'game-title-mul': 'Tên game ít nhất phải chứa từ 6 ký tự !',
		'game-date-mul': 'Thời gian kết thúc phải lớn hơn hiện tại !',
		'game-bitcoin-price-upper': 'Giá bitcoin trên khoảng phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !',
		'game-bitcoin-price-lower': 'Giá bitcoin dưới khoảng phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !',
	};	

	var priceInput = function () {
		return ['#game-bitcoin-price-upper', '#game-bitcoin-price-lower'];
	}

	var inputs = function () {
		return ['input#game-title-mul', 'input#game-date-mul', 'input#game-time-mul', 'input#game-bitcoin-price-upper', 'input#game-bitcoin-price-lower'];
	};


	function MulGame (gameTitle = '', gameEndDate = '', gameEndTime = '', lower = 0, upper = 0) {
		this.gameTitle = gameTitle;
		this.gameEndDate = gameEndDate;
		this.gameEndTime = gameEndTime;
		this.lower = lower;
		this.upper = upto;
	}

	return {
		inputs: inputs(),
		inputID: inputID,
		MulGame: MulGame,
		priceInput: priceInput(),
		validFormat: validFormat,
		panel: 'div#multi-choice-game',
		invalidFormatMessage: invalidFormatMessage
	};

})();