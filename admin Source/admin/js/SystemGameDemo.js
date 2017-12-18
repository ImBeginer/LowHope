  function endGame(id) {
	$.ajax({
		url: 'http://localhost:3333/api/game/systemgame',
		type: 'POST',
		dataType: 'text',
		data: {
			GAME_ID : id
		},
	})
	.done(function(response) {
		if (response == 1) {
			toatMessage('Success', '<b>Đã kết thúc game!</b>', 'success');
			location.reload();
		} else {
			toatMessage('Error', '<b>Có lỗi xảy ra! Vui lòng thử lại sau!</b>', 'error');
		}
	})
	.fail(function(response) {
		console.log("error");
	});
}

/**
 * [toatMessage description]
 * @param  {[type]} heading [description]
 * @param  {[type]} text    [description]
 * @param  {[type]} icon    [description]
 * @return {[type]}         [description]
 */
function toatMessage(heading,text,icon) {
	$.toast({
		heading: heading,
		text: text,
		showHideTransition: 'slide',
		icon: icon,
		position: 'bottom-right',
		hideAfter: 5000
	});
}

$('#btn-system-game').on('click', function () {
	alert($(this).val());
});