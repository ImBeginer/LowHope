var yesnogame = (function () {

	var inputID = {
		'game-title': 'Tên game',
		'game-date-yn': 'Ngày kết thúc',
		'game-time': 'Thời gian kết thúc',
		'game-bitcoin-price': 'Giá bitcoin'
	};

	var validFormat = {

		'game-title': '^.{6,35}$',
		'game-bitcoin-price': '^\\d{7,10}$'

	};

	var invalidFormatMessage = {

		'game-title': 'Tên game phải chứa từ 6 đến 35 ký tự',
		'game-bitcoin-price': 'Giá bitcoin phải trên 1 triệu và dưới 1 tỷ VNĐ'		

	};	

	var inputs = function () {
		return ['input#game-title', 'input#game-date-yn', 'input#game-time', 'input#game-bitcoin-price'];
	};

	function Yesnogame (gameTitle = '', gameEndDate = '', gameEndTime = '') {

		this.gameTitle = gameTitle;
		this.gameEndDate = gameEndDate;
		this.gameEndTime = gameEndTime;
		
	}

	return {
		inputs: inputs(),
		inputID: inputID,
		Yesnogame: Yesnogame,
		panel: 'div#yes-no-game',
		validFormat: validFormat,
		invalidFormatMessage: invalidFormatMessage
	};

})();