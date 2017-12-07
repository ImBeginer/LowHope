function forgotPassword() {
	var email = $('#fgemail').val();
	email = email.trim();
	console.log(email);
	$.ajax({
		url: base_url + 'ForgotPassword/forgotPassword',
		type: 'POST',
		dataType: 'text',
		data: {
			email: email
		},
	})
	.done(function(response) {
		if (response == 1) {
			toatMessage('Success', 'Mật khẩu mới đã được gửi về hòm thư của bạn!', 'success');
			window.location.href = base_url + "Login/logOut";
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