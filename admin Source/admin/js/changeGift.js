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


function checkPermission(email, password) {
	var win_1st = $('#new-price-tradi-1st').val();
	var win_2nd = $('#new-price-tradi-2nd').val();
	var win_3rd = $('#new-price-tradi-3rd').val();
	var noti_id = $('#tradi-notifi-form').val();
	$.ajax({
		url: base_url + 'ChangeGift/checkPermission',
		type: 'POST',
		dataType: 'text',
		data: {
			email : email,
			password : password,
			win_1st : win_1st,
			win_2nd : win_2nd,
			win_3rd : win_3rd,
			noti_id : noti_id
		},
	})
	.done(function(response) {
		console.log(response);
		if (response == 1) {
			toatMessage('Success', '<b>Cập nhật thành công!</b>', 'success');
		} else if (response == 2){
			toatMessage('Error', '<b>Email hoặc mật khẩu không đủ quyền hạn! Vui lòng thử lại sau!</b>', 'error');
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