$(document).ready(function() {
	/**
	 * update informations of user, (click Cập nhật thông tin -> popup update)
	 */
	$('#update-btn').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		var username = $('#username').val() || "";
		var userphone = $('#userphone').val() || "";
		var useraddress = $('#useraddress').val() || "";

		if(username && userphone && useraddress){
			$.ajax({
				url: base_url + 'userct/updateUser',
				type: 'POST',
				dataType: 'JSON',
				data: {
					username: username,
					userphone: userphone,
					useraddress: useraddress
				},
			})
			.done(function(respone) {
				console.log("success");
				if(respone == 1){
					$('#user_name').text(username);
					$('.username.ellipsis').text(username);					
					toatMessage('Success','Chúc mừng bạn đã cập nhật thông tin thành công !','success');
				}else {
					toatMessage('Warning','Bạn không có quyền thay đổi thông tin !!!','warning');
				}
			})
			.fail(function(respone) {
				console.log("error");
			})
			.always(function(respone) {
				console.log("complete");
			});
		}else {
			toatMessage('Warning','Vui lòng nhập đúng định dạng trường thông tin !','warning');
		}
	});

	/**
	 * Người chơi đặt giá bitcoin cho game truyền thống
	 */
	
	$('#c-bet-btn').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		var el = $('#point-input').val();
		var price_bet = parseFloat(el)|| 0;
		if(price_bet > 0){				
			$.ajax({
				url: base_url + 'gamect/log_game_tt',
				type: 'POST',
				dataType: 'JSON',
				data: {price_bet: price_bet},
			})
			.done(function(respone) {
				if(respone == 0){
					toatMessage('Warning','Đại ca! Có gì đó sai sai, ta nên thử lại sau...','warning');
					$('#point-input').val("");						
				}else if(respone == 1){
					toatMessage('Success','Bạn đã dự đoán thành công, Chờ có kết quả thôi nào !!!','success');
					$('#point-input').val("");
				}else if(respone == 2) {
					toatMessage('Warning','Vui lòng nhập đúng định dạng trường dự đoán !','warning');
					$('#point-input').val("");
					$('#point-input').focus();
				}
			})
			.fail(function(respone) {
				console.log("error");
			})
			.always(function(respone) {
				console.log("complete");
			});
		}else {
			toatMessage('Warning','Vui lòng nhập đúng định dạng trường dự đoán !','warning');
			$('#point-input').val("");
			$('#point-input').focus();
		}
	});

	/*
		Update the first login
	 */
	$('#btn-add-user').on('click', function(event) {
		/* Act on the event */
		var user_name = $('#fullName').val() || "";
		var user_phone = $('#phoneNumber').val() || "";
		var user_address = $('#address').val() || "";

		if(user_name && user_phone && user_address){
			$.post(base_url +'login/addUser', 
				{USER_NAME: user_name, USER_PHONE: user_phone, USER_ADDRESS: user_address}, 
				function(data) {
					if(data == 0){
						window.location.href = base_url;
					}else if(data == 1){
						window.location.href = base_url +'userct/home';
					}
				});			
		}else{
			toatMessage('Warning','Vui lòng nhập đúng định dạng trường update !','warning');
		} 
	});

	/**
	 * create game yes/no
	 */
	
	 $('#game-btn-yes-no').on('click', function(event) {
	 	event.preventDefault();
	 	/* Act on the event */
	 	var game_title = $('#game-title').val()||"";
	 	var end_date = $('#game-date-yn').val() || "";
	 	var end_time = $('#game-time').val() || "";
	 	var game_bitcoin_price = $('#game-bitcoin-price').val()||"";

	 	if(game_title && end_date && end_time && game_bitcoin_price){

	 		end_date = end_date.split('/');
	 		end_time = end_time.split(':');
	 		var end_date_time = (new Date(end_date[2],end_date[1]-1,end_date[0], end_time[0], end_time[1])).getTime();
	 		var current_date = new Date().getTime();

	 		if(end_date_time > current_date){

	 			$.ajax({
	 				url: base_url + 'gameCT/createGameYN',
	 				type: 'POST',
	 				dataType: 'JSON',
	 				data: {end_date_time: end_date_time, price_bet:game_bitcoin_price},
	 			})
	 			.done(function(respone) {
	 				console.log("success");
	 				if(respone == 1){
	 					toatMessage('Success', 'Bạn đã tạo game thành công !','success');
	 				}else if(respone == 0){
	 					toatMessage('Warning', 'Có lỗi xảy ra, vui lòng thử lại sau !','warning');
	 				}
	 			})
	 			.fail(function(respone) {
	 				console.log("error");
	 			})
	 			.always(function(respone) {
	 				console.log("complete");
	 			});
	 			
	 		}else{
	 			toatMessage('Warning', 'Thời gian kết thúc phải lớn hơn thời gian hiện tại','warning');
	 		}
	 	}

	 });

	 /**
	  * create game multi
	  */
	 


	/**
	 * Đếm ngược ngày kết thúc game truyền thống
	 */
	countDown_End_Date(tt_game_end_date);
});

// Đếm ngược ngày kết thúc game truyền thống
function countDown_End_Date(string_end_date) {
	var end_date = (new Date(string_end_date)).getTime();
	var x = setInterval(function(){
		// Get todays date and time
    	var now = new Date().getTime();
    	// Find the distance between now an the count down date
    	var distance = end_date - now;
    	// Time calculations for days, hours, minutes and seconds
	    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

	    // Output the result in an element
	    document.getElementById("countDown").innerHTML = days + "d " + hours + "h "
	    + minutes + "m " + seconds + "s ";
	    
	    // If the count down is over, write some text 
	    if (distance < 0) {
	        clearInterval(x);
	        document.getElementById("countDown").innerHTML = "EXPIRED";
	    }
	}, 1000);
}

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

function validation() {
	var elements = $("INPUT");
	for (var i = 0; i < elements.length; i++) {
		elements[i].oninvalid = function(e) {
			e.target.setCustomValidity("");
			if (!e.target.validity.valid) {
				switch (e.target.name) {
					default:
					e.target.setCustomValidity("Thông tin không được để trống");
					break;
					case 'username':
					if (e.target.validity.valueMissing) {
						e.target.setCustomValidity("Thông tin không được để trống");
					}
					break;
					case 'userphone':
					if (e.target.validity.valueMissing) {
						e.target.setCustomValidity("Số điện thoại không thể trống");
					} else if (e.target.validity.patternMismatch) {
						e.target.setCustomValidity("Số điện thoại không hợp lệ");
					}
					break;
					case 'useraddress':
					if (e.target.validity.valueMissing) {
						e.target.setCustomValidity("Thông tin không được để trống");
					}
					break;
				}
			}
		};
		elements[i].oninput = function(e) {
			e.target.setCustomValidity("");
		};
	}
}