$(document).ready(function() {
	/**
	 * update informations of user, (click Cập nhật thông tin -> popup update)
	 */
	
	$('#update-btn').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		
		var username = $('#username').val();
		var userphone = $('#userphone').val();
		var useraddress = $('#useraddress').val();

		$.ajax({
			url: base_url + 'userController/updateUser',
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

				$.toast({
					heading: 'Success',
					text: 'Chúc mừng bạn đã cập nhật thông tin thành công !',
					showHideTransition: 'slide',
					icon: 'success',
					position: 'bottom-right',
					hideAfter: 3000
				})
			}else {
				$.toast({
					heading: 'Warning',
					text: 'Bạn không có quyền thay đổi thông tin !!!',
					showHideTransition: 'slide',
					icon: 'warning',
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

	/**
	 * Người chơi đặt giá bitcoin cho game truyền thống
	 */
	
	$('#c-bet-btn').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		var el1 = $('#point-input').val();
		var el2 = $('#user-point').text();
		var price_bet = parseFloat(el1)|| 0;
		var user_point = parseFloat(el2);
		if(user_point >= price_bet){
			if(price_bet > 0){				
				$.ajax({
					url: base_url + 'GameController/add_Ans_Game_TT',
					type: 'POST',
					dataType: 'JSON',
					data: {price_bet: price_bet},
				})
				.done(function(respone) {
					if(respone == 0){
						$.toast({
							heading: 'Warning',
							text: 'Đại ca! Có gì đó sai sai, ta nên thử lại sau...',
							showHideTransition: 'slide',
							icon: 'warning',
							position: 'bottom-right',
							hideAfter: 3000
						})
						$('#point-input').val("");						
					}else if(respone == 1){
						$.toast({
							heading: 'Success',
							text: 'Chúc mừng bạn đã đặt cược thành công !',
							showHideTransition: 'slide',
							icon: 'success',
							position: 'bottom-right',
							hideAfter: 3000
						})
						$('#point-input').val("");
					}else {
						notEnoughPoint();
					}
				})
				.fail(function(respone) {
					console.log("error");
				})
				.always(function(respone) {
					console.log("complete");
				});
			}else {
				$.toast({
					heading: 'Warning',
					text: 'Vui lòng nhập đúng định dạng trường đặt cược !',
					showHideTransition: 'slide',
					icon: 'warning',
					position: 'bottom-right',
					hideAfter: 3000
				});
				$('#point-input').val("");
				$('#point-input').focus();
			}
		}else {
			notEnoughPoint();
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

	    // Output the result in an element with id="demo"
	    document.getElementById("countDown").innerHTML = days + "d " + hours + "h "
	    + minutes + "m " + seconds + "s ";
	    
	    // If the count down is over, write some text 
	    if (distance < 0) {
	        clearInterval(x);
	        document.getElementById("countDown").innerHTML = "EXPIRED";
	    }
	}, 1000);
}

function notEnoughPoint() {
	$.toast({
		heading: 'Warning',
		text: 'Bạn không có đủ số point để đặt cược !',
		showHideTransition: 'slide',
		icon: 'warning',
		position: 'bottom-right',
		hideAfter: 3000
	});
	$('#point-input').val("");
	$('#point-input').focus();
}
