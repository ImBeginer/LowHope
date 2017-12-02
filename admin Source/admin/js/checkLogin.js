function checkLogin() {

	var email = $('#username').val();
	var pass = $('#password').val();
	console.log(email + '   ' + pass);

	$.ajax({
		url: base_url + 'Login/logIn',
		type: 'POST',
		dataType: 'text',
		data: {
			email : email,
			pass : pass
		},
	})
	.done(function(response) {
		console.log(response);
		if (response == '1') {
			toatMessage('Success', '<b>Đăng nhập thành công!</b>', 'success');
			window.location.replace(base_url + 'Home');
		} else {
			toatMessage('Error', '<b>Email hoặc mật khẩu sai! Vui lòng thử lại!</b>', 'error');
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