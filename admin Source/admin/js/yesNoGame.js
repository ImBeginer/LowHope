var yesnogame = (function () {

	var inputID = {
		'game-title': 'Tên game',
		'game-date-yn': 'Ngày kết thúc',
		'game-time': 'Thời gian kết thúc',
		'game-bitcoin-price': 'Giá bitcoin',
		'emptyInputMessage': {
			'game-title': 'Tên game ít nhất phải chứa từ 6 ký tự !',
			'game-date-yn': 'Thời gian kết thúc phải lớn hơn hiện tại !',
			'game-time': 'Thời gian kết thúc phải lớn hơn hiện tại !',
			'game-bitcoin-price': 'Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !',
		}
	};

	var validFormat = {
		'game-title': '^.{6,}$',
		'game-date-yn': '^(?:(?:31(\\/|-|\\.)(?:0?[13578]|1[02]))\\1|(?:(?:29|30)(\\/|-|\\.)(?:0?[1,3-9]|1[0-2])\\2))(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$|^(?:29(\\/|-|\\.)0?2\\3(?:(?:(?:1[6-9]|[2-9]\\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\\d|2[0-8])(\\/|-|\\.)(?:(?:0?[1-9])|(?:1[0-2]))\\4(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$',
		'game-bitcoin-price': '^\\s*(?=.*[1-9])\\d*(?:[^,;]+\\.\\d{1,2})?\\s*$',
	};

	var invalidFormatMessage = {
		'game-title': 'Tên game ít nhất phải chứa từ 6 ký tự !',
		'game-date-yn': 'Thời gian kết thúc phải lớn hơn hiện tại !',
		'game-bitcoin-price': 'Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !'		
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
		panel: 'div#manager-create-game div#yes-no-game',
		validFormat: validFormat,
		invalidFormatMessage: invalidFormatMessage
	};

})();