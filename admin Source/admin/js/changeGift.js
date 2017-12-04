/**
 * [selectNoti description]
 * @return {[type]} [description]
 */
function selectNoti () {
	var id = $('#tradi-notifi-form').val();
	if (id == 0) {
		$('#tradi-gift-notifi').text('');
		return;
	}
	for (var i = 0; i < listNoti.length; i++) {
		if (listNoti[i]['NOTICE_ID'] == id) {
			$('#tradi-gift-notifi').text(listNoti[i]['CONTENT']);
			return;
		}
	}
}


function saveAward() {
	var win_1st = $('new-price-tradi-1st').val();
	var win_1st = $('new-price-tradi-1st').val();
	var win_1st = $('new-price-tradi-1st').val();
}