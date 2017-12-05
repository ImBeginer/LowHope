function changePass() {
	var old_pass = $('#oldpass').val();
	var new_pass = $('#newpass').val();
	var confirm_pass = $('#confirmpass').val();

		$.ajax({
		url: base_url + 'ChangePassword/changePassword',
		type: 'POST',
		dataType: 'text',
		data: {
			id : user_id,
			old_pass: old_pass,
			new_pass: new_pass,
			confirm_pass : confirm_pass
		},
	})
	.done(function(response) {
		if (response == 1) {
			toatMessage('Success', '<b>Đổi mật khẩu thành công!</b>', 'success');
			$('#oldpass').val('');
			$('#newpass').val('');
			$('#confirmpass').val('');
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