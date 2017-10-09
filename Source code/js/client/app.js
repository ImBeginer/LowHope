$(document).ready(function() {
	/**
	 * update informations of user, (click Cập nhật thông tin -> popup update)
	 */
	
	$('.update-btn').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		
		var username = $('#username').val();
		var userphone = $('#userphone').val();
		var useraddress = $('#useraddress').val();

		//alert(username + ' - ' + userphone + ' - ' + useraddress);
		$.ajax({
			url: base_url + 'userController/updateUser',
			type: 'POST',
			dataType: 'JSON',
			data: {
				userId:userId,
				username: username,
				userphone: userphone,
				useraddress: useraddress
			},
		})
		.done(function(respone) {
			console.log("success");
			if(respone == 1){
				$('#user_name').text(username);
				$.toast({
					heading: 'Success',
					text: 'Chúc mừng bạn đã cập nhật thông tin thành công !',
					showHideTransition: 'slide',
					icon: 'info',
					position: 'bottom-right',
					hideAfter: 3000
				})
			}else {
				$.toast({
					heading: 'Warning',
					text: 'Bạn không có quyền thay đổi thông tin !!!',
					showHideTransition: 'slide',
					icon: 'info',
					position: 'bottom-right',
					hideAfter: 3000
				})
			}
		})
		.fail(function(respone) {
			console.log("error");
		})
		.always(function(respone) {
			console.log("complete");
		});
		
	});
});