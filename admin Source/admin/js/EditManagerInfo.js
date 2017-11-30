/**
 * [checkChange description]
 * @param  {[type]} user_name [description]
 * @param  {[type]} phone     [description]
 * @param  {[type]} address   [description]
 * @param  {[type]} email     [description]
 * @return {[type]}           [true - changed and false - not change]
 */
function checkChange(user_name, phone, address, email) {
	if (user_name == '' && phone == '' && address == '' && email == '') {
		toatMessage('Error', 'Bạn cần phải nhập thông tin thay đổi!', 'error');
		return false;
	} else if (user_name == user_name_original && phone == phone_original && address == address_original && email == email_original) {
		toatMessage('Warning', 'Dữ liệu không có gì thay đổi!', 'warning');
		return false;
	} else {
		var regex = new RegExp('^(([^<>()\\[\\]\\\.,;:\\s@"]+(\\.[^<>()\\[\\]\\\.,;:\\s@"]+)*)|(".+"))@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\])|(([a-zA-Z\\-0-9]+\\.)+[a-zA-Z]{2,}))$');
		var checkEmail = regex.test(email);
		if (checkEmail) {
			return true;
		}
		return false;
	}	
}

function sentToUpdate(user_name, phone, address) {
	$.ajax({
		url: base_url + 'EditManagerInfo/updateInfo',
		type: 'POST',
		dataType: 'text',
		data: {
			id: user_id,
			userName : user_name,
			phone : phone,
			address : address
		},
	})
	.done(function(response) {
		console.log(response);
		if (response == 1) {
			toatMessage('Success', '<b>Cập nhật thành công!</b>', 'success');
			location.reload();
		} else  {
			toatMessage('Error', 'Cập nhật không thành công!', 'error');
		}
	})
	.fail(function(response) {
		console.log("error");
	});
}


/**
 * [function to update information to db]
 * @param  {[type]} id       [user id]
 * @param  {[type]} userName [user name]
 * @param  {[type]} phone    [phone number]
 * @param  {[type]} address  [address]
 * @param  {[type]} email    [emanil]
 * @return {[type]}          [true to update successful or false to update]
 */
function updateInfor() {
	var user_name = $('#m-name').val();
	var phone = $('#m-phone').val();
	var address = $('#m-address').val();
	var email = $('#m-email').val();
	console.log(user_name, phone, address, email);
	if (checkChange(user_name, phone, address, email)) {
		sentToUpdate(user_name, phone, address, email);
	} else {
		sentToUpdate(user_name, phone, address, email);
	}
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


// $('button[name=m-update-info-btn]').on('click', function(){
// 	updateInfor
// });
