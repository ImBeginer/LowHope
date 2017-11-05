var yesnogame = (function () {

	var inputID = {
		'game-title': 'Tên game',
		'game-date-yn': 'Ngày kết thúc',
		'game-time': 'Thời gian kết thúc',
		'game-bitcoin-price': 'Giá bitcoin'
	};

	var validFormat = {

		'game-title': '^.{6,35}$',
		'game-date-yn': '^(?:(?:31(\\/|-|\\.)(?:0?[13578]|1[02]))\\1|(?:(?:29|30)(\\/|-|\\.)(?:0?[1,3-9]|1[0-2])\\2))(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$|^(?:29(\\/|-|\\.)0?2\\3(?:(?:(?:1[6-9]|[2-9]\\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\\d|2[0-8])(\\/|-|\\.)(?:(?:0?[1-9])|(?:1[0-2]))\\4(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$',
		'game-bitcoin-price': '^\\d{1,10}$'

	};

	var invalidFormatMessage = {

		'game-title': 'Tên game phải chứa từ 6 đến 35 ký tự',
		'game-date-yn': 'Cẩn thận ăn đòn nhé sai ngày kết thúc rồi :)',
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
		panel: 'div#create-game div#yes-no-game',
		validFormat: validFormat,
		invalidFormatMessage: invalidFormatMessage
	};

})();