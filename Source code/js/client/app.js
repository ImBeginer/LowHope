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
					$('#username-btn').text(username);
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
	 	console.log(checkData.checked);

	 	if(checkData.checked){

		 	var game_title = $('#game-title').val()||"";
		 	var end_date = $('#game-date-yn').val() || "";
		 	var end_time = $('#game-time').val() || "";
		 	var game_bitcoin_price = $('#game-bitcoin-price').val()||"";

	 		end_date = end_date.split('/');
	 		end_time = end_time.split(':');
	 		var end_date_time = (new Date(end_date[2],end_date[1]-1,end_date[0], end_time[0], end_time[1])).getTime();
	 		var current_date = new Date().getTime();

	 		if(end_date_time > current_date){

	 			$.ajax({
	 				url: base_url + 'gameCT/createGameYN',
	 				type: 'POST',
	 				dataType: 'JSON',
	 				data: {game_title: game_title, end_date_time: end_date_time, price_bet:game_bitcoin_price},
	 			})
	 			.done(function(respone) {
	 				console.log("success");
	 				if(respone.create == 1){
	 					$('#user-point').text(respone.user_point);
	 					toatMessage('Success', 'Bạn đã tạo game thành công !','success');
	 				}else if(respone.create == 0){
	 					toatMessage('Warning', 'Có lỗi xảy ra, vui lòng thử lại sau !','warning');
	 				}else if(respone.create == 2){
	 					toatMessage('Info', 'Bạn không có đủ Point để tạo thêm game mới !<br>(Các game bạn tạo vẫn chưa kết thúc)','info');
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
	 * create game multiple choice
	 */
	$('#game-btn-mul').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */

 		if(checkData.isDataChecked){
			var game_title_mul = $('#game-title-mul').val() || "";
			var end_date_mul = $('#game-date-mul').val() || "";
			var end_time_mul = $('#game-time-mul').val() || "";
			var price_below = $('#game-bitcoin-price-lower').val() || "";
			var price_above = $('#game-bitcoin-price-upper').val() || "";

			end_date_mul = end_date_mul.split('/');
	 		end_time_mul = end_time_mul.split(':');
 			
 			var end_date_time = (new Date(end_date_mul[2],end_date_mul[1]-1,end_date_mul[0], end_time_mul[0], end_time_mul[1])).getTime();
	 		
	 		$.ajax({
	 			url: base_url + 'gamect/createGameMulti',
	 			type: 'POST',
	 			dataType: 'JSON',
	 			data: {game_title_mul: game_title_mul, end_date_time:end_date_time, price_below:price_below, price_above:price_above},
	 		})
	 		.done(function(respone) {
	 			console.log("success");
	 			if(respone.create == 1){
	 				$('#user-point').text(respone.user_point); 				
	 				toatMessage('Success', 'Bạn đã tạo game thành công !','success');
	 			}else if(respone.create == 0){
	 				toatMessage('Warning', 'Có lỗi xảy ra, vui lòng thử lại sau !','warning');
	 			}else if(respone.create == 2){
					toatMessage('Info', 'Bạn không có đủ Point để tạo thêm game mới !<br>(Các game bạn tạo vẫn chưa kết thúc)','info');
				}
	 		})
	 		.fail(function(respone) {
	 			console.log("error");
	 		})
	 		.always(function(respone) {
	 			console.log("complete");
	 		});
 		}
	});
	 


	$('.hot-item').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		var target = $(this);
		var game_id = target.attr('data-gameid');
		var game_type = target.attr('data-gametype');

		if(game_type == 1){
			window.location = 'history.php';


		}else if(game_type == 2){
			window.location = 'history.php';

		}

	});


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