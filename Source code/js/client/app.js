$(document).ready(function() {

// ************************CHECK DỮ LIỆU ĐẦU VÀO**************************

  /**
   * [isEmpty kiểm tra xem input có rỗng hay không]
   * @param  {Object}  $inputTarget [dữ liệu input cần check]
   * @return {Boolean} [trả về true nếu rỗng ngược lại trả về false]
   */
   function isEmpty ($inputTarget = null) {
    	// console.log ($inputTarget);
    	return $inputTarget.val() === "" ? true : false;
	}

  /**
   * [isValidFormat kiểm tra xem dữ liệu input có đúng theo form hay không]
   * @param  {Object}  $inputTarget [dữ liệu input cần check]
   * @param  {String}  $regex       [format quy chuẩn]
   * @return {Boolean}              [trả về true nếu đúng format ngược lại trả về false]
   */
   function isValidFormat ($inputTarget = null, $regex = '') {
		$inputData = $inputTarget.val();
	   	$regexFormat = new RegExp ($regex);

	   	return $regexFormat.test($inputData);
   }

  /**
   * [isInputEmpty kiểm tra dữ liệu có rỗng hay không]
   * @param  {Object}  $inputData [dữ liệu tiêu chuẩn]
   * @param  {Array}   $data      [dữ liệu input cần check]
   * @return {Boolean}            [trả về true nếu dữ liệu rỗng ngược lại trả về false]
   */
   function isInputEmpty ($inputData = null, $panel, $data = []) {

	   	if ($data.length === 0) {
	   		return true;
	   	}

	   	for ($i = 0; $i < $data.length; $i++) {
	   		$inputID = $($data[$i]).attr ('id');

	   		if (isEmpty ($($panel + ' ' + '#' + $inputID))) {
	   			if ($inputData.hasOwnProperty ($inputID)) {
	   				$message += '<p class="error animated shake">' + $inputData [$inputID] + ' không hợp lệ</p>'; 
	   			}
	   		}
	   	}

	   	if ($message !== '') {
	   		displayMessage ($panel, $message);

	   		return true;
	   	} else {

	   		return false;
	   	}
   }

  /**
   * [isInvalidFormat kiểm tra dữ liệu có đúng format hay không]
   * @param  {Object}  $inputData      [dữ liệu tiêu chuẩn]
   * @param  {[type]}  $inputFormat    [format tiêu chuẩn]
   * @param  {[type]}  $invalidMessage [lỗi thông báo tiêu chuẩn]
   * @param  {Array}   $data           [dữ liệu input cần check]
   * @return {Boolean}                 [trả về true nếu dữ liệu không đúng format ngược lại trả về false]
   */
   function isInvalidFormat ($inputData = null, $inputFormat = null, $invalidMessage = null, $panel, $data = []) {

	   	$message = '';

	   	if ($data.length === 0) {
	   		return true;
	   	}

	   	for ($i = 0; $i < $data.length; $i++) {
	   		$inputID = $($data[$i]).attr ('id');

	   		if ($inputData.hasOwnProperty ($inputID)) {
	   			if (!isValidFormat ($($panel + ' ' + '#' + $inputID), $inputFormat [$inputID])) {
	   				$message += '<p class="error animated shake">' + $invalidMessage [$inputID] + '</p>';
	   			}
	   		}
	   	}

	   	if ($message !== '') {
	   		displayMessage ($panel, $message);

	   		return true;
	   	} else {

	   		return false;
	   	}
   } 

  /**
   * [isPriceValid kiểm tra giá bitcoin có hợp lệ hay không]
   * @param  {Object}  $object [description]
   * @return {Boolean}         [trả về true nếu giá bitcoin hợp lệ ngược lại trả về false]
   */
   function isPriceValid ($object) {
	   	$message = '';

	   	$upper = $($object.priceInput[0]).val();
	   	$lower = $($object.priceInput[1]).val();

	   	try {
	   		$upper = parseFloat($upper);
	   		$lower = parseFloat($lower);

	   		if ($upper < 0 || $lower < 0) {
	   			$message += '<p class="error animated shake">Giá bitcoin trên khoảng hoặc dưới khoảng không thể âm</p>';
	   		} else if (isNaN($upper) || isNaN($lower)) {
	   			$message += '<p class="error animated shake">Giá bitcoin trên khoảng hoặc dưới khoảng không hợp lệ</p>'; 
	   		} else if ($lower > $upper) {
	   			$message += '<p class="error animated shake">Giá bitcoin trên khoảng phải nhỏ hơn dưới khoảng</p>';
	   		}
	   	} catch (error) {
	   		console.log (error);
	   	}

	   	if ($message !== '') {
	   		displayMessage ($object.panel, $message);

	   		return false;
	   	} else {
	   		return true;
	   	}
   }

  /**
   * [displayMessage hiển thị thông báo lỗi nếu input không hợp lệ]
   * @param  {String} $message [thông báo cần hiển thị]
   */
   function displayMessage ($panel, $message = '') {
   		$($panel + ' .message').html ($message);
   }

  /**
   * [isValidData kiểm tra dữ liệu đầu vào có hợp lệ hay không]
   * @param  {Array} $data [dữ liệu input cần check]
   * @return {Boolean} [trả về true nếu dữ liệu hợp lệ, ngược lại trả về false]
   */
   function isValidData ($object) {

	   	$data = $object.inputs;
	   	$panel = $object.panel;
	   	$inputData = $object.inputID;
	   	$inputFormat = $object.validFormat;
	   	$invalidMessage = $object.invalidFormatMessage;

	   	$message = '';
	   	if (!isInputEmpty ($inputData, $panel, $data)) {

	   		if (!isInvalidFormat ($inputData, $inputFormat, $invalidMessage, $panel, $data)) {
	   			displayMessage ($panel, '<p class="valid animated shake">Dữ liệu hợp lệ</p>');

	   			return true;
	   		} 
	   	}
	   	return false;    
	   }

	   $('button[name=game-btn-mul]').on('click', function () {
		   	isDataChecked = false;
		   	$mulGameObject = mulGame;
		   	if (isValidData ($mulGameObject) && isPriceValid ($mulGameObject)) {
		   		isDataChecked = true;
		   		$('#create-game').modal('hide');
		   	}
   		});      
	/**************************************END CHECK DỮ LIỆU ĐẦU VÀO********************************************/

	/********************************************* LOGIN *****************************************************/

	/**
	 * Người chơi đăng nhập vào hệ thống
	 */
	$('button#user-login').on('click', function() {
		event.preventDefault();

		//Dieu kien???

		var email = $('#username').val();
		var pass = $('#userpassword').val();

		//Check email exist ??
		$.ajax({
			url: base_url + 'userct/checkUserExist',
			type: 'POST',
			dataType: 'JSON',
			data: {email: email, pass: pass},
		})
		.done(function(response) {
			if(response == 1){
				$.ajax({
					url: base_url + 'userct/add_other_user',
					type: 'POST',
					dataType: 'JSON',
					data: {email: email, pass: pass}
				})
				.done(function(response) {
					console.log("success");
					if(response == 1){
						window.location.href = base_url + 'userct/home';
					}else{
						window.location.href = base_url;
					}
				})
				.fail(function(response) {
					console.log("error");
				});
			}else if(response == 2){
				window.location.href = base_url + 'userct/home';
			}else if(response == 0){
				toatMessage('Warning', 'Sai password, vui lòng thử lại !', 'warning');
			}
		})
		.fail(function(response) {
			console.log("error");
		});
	});

	/**
	 * Đổi mật khẩu người dùng
	 */
	$('button#user-forgot-pass').on('click', function () {
	  	$object = forgotPass;
	  	if (isValidData ($object)) {
		    if (passwordIsMatch ($object)) {
		      	console.log ("OKE"); 
		      	//TODO
		    }
	  	}
	});

	/**
	 * Xác thực mã xác nhận gửi cho người chơi qua email
	 */
	$('button[name=user-send-confirm-code-btn]').on('click', function () {
	  	$emailVal = $('input#forgot-email').val();
	  	if ($emailVal === '') {
	    	displayMessage ('div#user-login-panel', '<p class="error animated shake">Email không được trống</p>');
	  	}else {
		    $regexFormat = new RegExp('^(([^<>()\\[\\]\\\.,;:\\s@"]+(\\.[^<>()\\[\\]\\\.,;:\\s@"]+)*)|(".+"))@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\])|(([a-zA-Z\\-0-9]+\\.)+[a-zA-Z]{2,}))$');
		    if (!$regexFormat.test($emailVal)) {
		      	displayMessage ('div#user-login-panel', '<p class="error animated shake">Email không hợp lệ</p>');  
		    }else {
		      	console.log('EMAIL OKE');  
		    }
	  	}

	});
	/************************************** END LOGIN **************************************************************/



	/************************************ USER ACTIVITIES ******************************************************/
	/**
	 * update informations of user, (click Cập nhật thông tin -> popup update)
	 */
	$('#update-btn').on('click', function(event) {
	 	event.preventDefault();
	 	/* Act on the event */
	 	$userObject = user;
	 	console.log ($userObject);
	 	if (isValidData ($userObject)) {
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
	 			.done(function(response) {
	 				console.log("success");
	 				if(response == 1){
	 					$('#username-btn').text(username);
	 					$('.username.ellipsis').text(username);
	 					$('#tooltip-username').attr('data-original-title',username);				
	 					toatMessage('Success','Chúc mừng bạn đã cập nhật thông tin thành công !','success');
	 				}else {
	 					toatMessage('Warning','Bạn không có quyền thay đổi thông tin !!!','warning');
	 				}
	 			})
	 			.fail(function(response) {
	 				console.log("error");
	 			});
	 		}else {
	 			toatMessage('Warning','Vui lòng nhập đúng định dạng trường thông tin !','warning');
	 		}
	 	}
	 });

	/**
	 * Người chơi đặt giá bitcoin cho game truyền thống
	 */
	$('#bet-game_tt').on('click', function(event) {
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
	 		.done(function(response) {
	 			if(response == 0){
	 				toatMessage('Warning','Đại ca! Có gì đó sai sai, ta nên thử lại sau...','warning');
	 				$('#point-input').val("");						
	 			}else if(response == 1){
	 				toatMessage('Success','Bạn đã dự đoán thành công, Chờ có kết quả thôi nào !!!','success');
	 				$('#point-input').val("");
	 			}else if(response == 2) {
	 				toatMessage('Warning','Vui lòng nhập đúng định dạng trường dự đoán !','warning');
	 				$('#point-input').val("");
	 				$('#point-input').focus();
	 			}
	 		})
	 		.fail(function(response) {
	 			console.log("error");
	 		});
	 	}else {
	 		toatMessage('Warning','Vui lòng nhập đúng định dạng trường dự đoán !','warning');
	 		$('#point-input').val("");
	 		$('#point-input').focus();
	 	}
	 });

	/**
	 * Thêm mới người chơi
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
	 * Tạo game mini yes no
	 */
	$('#create-game-btn-yes-no').on('click', function(event) {
	 	event.preventDefault();

	 	$ynGameObject = yesnogame;
	 	if (isValidData ($ynGameObject)) {
	 		$('#create-game').modal('hide');

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
	 			.done(function(response) {
	 				console.log("success");
	 				if(response.create == 1){
	 					$('#user-point').text(response.user_point);
	 					toatMessage('Success', 'Chúc mừng bạn đã tạo game thành công !','success');
	 				}else if(response.create == 0){
	 					toatMessage('Warning', 'Hệ thống có lỗi xảy ra, vui lòng thử lại sau !','warning');
	 				}else if(response.create == 2){
	 					toatMessage('Info', 'Bạn không có đủ Point để tạo thêm game mới !<br>(Các game bạn tạo vẫn chưa kết thúc)','info');
	 				}
	 			})
	 			.fail(function(response) {
	 				console.log("error");
	 			});	 			
	 		}else{
	 			toatMessage('Warning', 'Thời gian kết thúc phải lớn hơn thời gian hiện tại','warning');
	 		}
	 	}
	});

	/**
	 * Tạo game mini multi
	 */
	$('#create-game-btn-mul').on('click', function(event) {
	 	event.preventDefault();
	 	/* Act on the event */
	 	$mulGameObject = mulGame;
	 	if (isValidData ($mulGameObject) && isPriceValid ($mulGameObject)) {

	 		var game_title_mul = $('#game-title-mul').val() || "";
	 		var end_date_mul = $('#game-date-mul').val() || "";
	 		var end_time_mul = $('#game-time-mul').val() || "";
	 		var price_below = $('#game-bitcoin-price-lower').val() || "";
	 		var price_above = $('#game-bitcoin-price-upper').val() || "";

	 		end_date_mul = end_date_mul.split('/');
	 		end_time_mul = end_time_mul.split(':');

	 		var end_date_time = (new Date(end_date_mul[2],end_date_mul[1]-1,end_date_mul[0], end_time_mul[0], end_time_mul[1])).getTime();
	 		var current_date = new Date().getTime();

	 		if(end_date_time > current_date){

		 		$.ajax({
		 			url: base_url + 'gamect/createGameMulti',
		 			type: 'POST',
		 			dataType: 'JSON',
		 			data: {game_title_mul: game_title_mul, end_date_time:end_date_time, price_below:price_below, price_above:price_above},
		 		})
		 		.done(function(response) {
		 			console.log("success");
		 			if(response.create == 1){
		 				$('#user-point').text(response.user_point); 
		 				toatMessage('Success', 'Bạn đã tạo game thành công !','success');
		 			}else if(response.create == 0){
		 				toatMessage('Warning', 'Có lỗi xảy ra, vui lòng thử lại sau !','warning');
		 			}else if(response.create == 2){
		 				toatMessage('Info', 'Bạn không có đủ Point để tạo thêm game mới !<br>(Các game bạn tạo vẫn chưa kết thúc)','info');
		 			}
		 		})
		 		.fail(function(response) {
		 			console.log("error");
		 		});
	 		}else {
	 			toatMessage('Warning', 'Thời gian kết thúc phải lớn hơn thời gian hiện tại','warning');
	 		}
	 	}
	});
	 
	/**
	 * Cược game mini yes no
	 */
	$('#bet-game-yes-no').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		var ans = $('input[name=yes-or-no]:checked').val();
		if(ans){
			var game_id = $('.mini-game-content').attr('data-gameid');
			$.ajax({
				url: base_url + 'gamect/log_game_yes_no',
				type: 'POST',
				dataType: 'JSON',
				data: {game_id: game_id, answer:ans},
			})
			.done(function(response) {
				if(response.result == 1){
					$('#user-point').text(response.user_point);
					toatMessage('Success', 'Chúc mừng bạn đặt cược thành công !', 'success');
				}else if(response.result == 2){
					toatMessage('Warning', 'Bạn đã đặt cược game này !<br>Vui lòng chọn game khác để chơi.', 'warning');
				}else if(response.result == 3){
					toatMessage('Warning', 'Bạn không đủ point để chơi !!!<br> (Các game bạn tạo vẫn chưa kết thúc)', 'warning');
				}else if(response.result == 4){
					toatMessage('Warning', 'Bạn không được chơi game do mình tạo ra', 'warning');
				}else if(response.result == 5){
					toatMessage('Warning', 'Rất tiếc, game này đã đủ người chơi.<br>Vui lòng chọn game khác để chơi.', 'warning');
				}
			}).fail(function() {
				console.log("error");
			});			
		}else{
			toatMessage('Warning','Bạn hãy đưa ra sự lựa chọn của mình !', 'warning');
		}
	});

	/**
	 * Cược game mini multi
	 */
	$('#bet-game-mul').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		var ans = $('select[name=mul-game]').val();
		if(ans){
			var game_id = $('.mini-game-content').attr('data-gameid');
			$.ajax({
				url: base_url + 'gamect/log_game_mul',
				type: 'POST',
				dataType: 'JSON',
				data: {game_id:game_id, answer: ans},
			})
			.done(function(response) {
				if(response.result == 1){
					$('#user-point').text(response.user_point);
					toatMessage('Success', 'Chúc mừng bạn đặt cược thành công !', 'success');
				}else if(response.result == 2){
					toatMessage('Warning', 'Bạn đã đặt cược game này !<br>Vui lòng chọn game khác để chơi.', 'warning');
				}else if(response.result == 3){
					toatMessage('Warning', 'Bạn không đủ point để chơi !!!<br> (Các game bạn tạo vẫn chưa kết thúc)', 'warning');
				}else if(response.result == 4){
					toatMessage('Warning', 'Bạn không được chơi game do mình tạo ra', 'warning');
				}else if(response.result == 5){
					toatMessage('Warning', 'Rất tiếc, game này đã đủ người chơi.<br>Vui lòng chọn game khác để chơi.', 'warning');
				}
			})
			.fail(function(response) {
				console.log("error");
			});
		}
	});
});

/**
 * [countDown_End_Date description] Đếm ngược thời gian hết hạn game truyền thống, game mini
 * @param  {[type]} string_end_date [description]
 * @param  {[type]} type            [description]
 * @return {[type]}                 [description]
 */
function countDown_End_Date(string_end_date,type) {
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
	    if(type == 0){
		    document.getElementById("countDown").innerHTML = days + "Day " + hours + "h "
		    + minutes + "m " + seconds + "s ";
		    
		    // If the count down is over, write some text 
		    if (distance < 0) {
		    	clearInterval(x);
		    	document.getElementById("countDown").innerHTML = "EXPIRED";
		    }		    	
	    }else if(type == 1){
	    	document.getElementById("game_mini_countdown").innerHTML = days + "Day " + hours + "h "
		    + minutes + "m " + seconds + "s ";
		    
		    // If the count down is over, write some text 
		    if (distance < 0) {
		    	clearInterval(x);
		    	document.getElementById("game_mini_countdown").innerHTML = "EXPIRED";
		    }
	    }
	}, 1000);
}

/**
 * [toatMessage description] Hiển thị message thông báo, warning
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

/**
 * [user_percent_in_de description] tỉ lệ người chơi đã cược game yes no
 * @param  {Number} $in_num [description]
 * @param  {Number} $de_num [description]
 * @return {[type]}         [description]
 */
function user_percent_in_de ($in_num = 0, $de_num = 0) {
    $percent_width = parseInt($('.percent-panel').css('width'), 10);

    $in_div = $('#increase');
    $de_div = $('#decrease');
    $in_user = $in_num;
    $de_user = $de_num;
    $total_user = parseInt($in_user) + parseInt($de_user);

    if ($total_user !== 0 && $total_user > 0) {
      	$in_div_width = Math.round(($percent_width * $in_user) / $total_user);
      	$de_div_width = $percent_width - $in_div_width;
    } else {
      	$de_div_width = $in_div_width = Math.round($percent_width / 2);
    }

    $in_per_string = Math.round(($in_div_width / $percent_width) * 100);
    $de_per_string = 100 - $in_per_string;

    $in_div.css({'width': $in_div_width + 'px'});
    $de_div.css({'width': $de_div_width + 'px'});

    $('span.in-num-percent').text($in_per_string + '%');
    $('span.de-num-percent').text($de_per_string + '%');
}

/**
 * [user_percent_mul description] tỉ lệ người chơi đã cược game multi
 * @param  {Number} $lower   [description]
 * @param  {Number} $between [description]
 * @param  {Number} $upper   [description]
 * @return {[type]}          [description]
 */
function user_percent_mul ($lower = 0, $between = 0, $upper = 0) {
    $percent_width = parseInt($('.game-mul.percent-panel').css('width'), 10) - 2;
    $total = parseInt($lower) + parseInt($between) + parseInt($upper);
    $lo_div = $('#increase');
    $be_div = $('#between');
    $up_div = $('#decrease');
    $lo_div_width = $be_div_width = $up_div_width = 0;

    if ($total !== 0 && $total > 0) {
      $lo_div_width = Math.round(($percent_width * $lower) / $total);
      $be_div_width = Math.round(($percent_width * $between) / $total);
      $up_div_width = $percent_width - $lo_div_width - $be_div_width;      
    } else {
      $lo_div_width = $be_div_width = $lo_div_width = Math.round($percent_width / 3) - 1;
    }

    $lo_per_string = Math.round(($lo_div_width / $percent_width) * 100);
    $be_per_string = Math.round(($be_div_width / $percent_width) * 100);
    $up_per_string = 100 - $lo_per_string - $be_per_string;

    $lo_div.css({'width': $lo_div_width + 'px'});
    $be_div.css({'width': $be_div_width + 'px'});
    $up_div.css({'width': $up_div_width + 'px'});

    $('.game-mul span.in-num-percent').text($lo_per_string + '%');
    $('.game-mul span.be-num-percent').text($be_per_string + '%');
    $('.game-mul span.de-num-percent').text($up_per_string + '%');
}

/**
 * [set_style_table_log_game description] đặt lại style cho bảng danh sách người chơi đã tham gia game mini
 */
function set_style_table_log_game() {
	var giaodich = $('.giaodich');
	giaodich[0].style.fontSize = '30px';
	giaodich[0].style.fontWeight = 'bold';

	var el_show = $('#list-bet-log_length');
	el_show[0].children[0].firstChild.textContent = 'Hiển thị ';
	el_show[0].children[0].firstChild.nextSibling.style.backgroundColor = '#777';
	el_show[0].children[0].firstChild.nextSibling.nextSibling.textContent = ' bản ghi';

	var el_search = $('#list-bet-log_filter');
	el_search[0].firstChild.firstChild.textContent = 'Tìm kiếm: ';
	el_search[0].style.width = '100%';
	el_search[0].firstChild.firstChild.nextSibling.style.width = '50%';
	el_search[0].firstChild.firstChild.nextSibling.style.float = 'right';
}