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

	// ************************END CHECK DỮ LIỆU ĐẦU VÀO**************************

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
	 			.done(function(respone) {
	 				console.log("success");
	 				if(respone == 1){
	 					$('#username-btn').text(username);
	 					$('.username.ellipsis').text(username);
	 					$('#tooltip-username').attr('data-original-title',username);				
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

	/**
	 * @param  {[type]}
	 * @param  {[type]}
	 * @return {[type]} add new user
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
	 		}else {
	 			toatMessage('Warning', 'Thời gian kết thúc phải lớn hơn thời gian hiện tại','warning');
	 		}
	 	}
	 });
	 

	/**
	 * game mini detail
	 * @param  {[type]}
	 * @return {[type]}
	 */
	$('.hot-item').on('click', function(event) {
	 	event.preventDefault();
	 	/* Act on the event */
	 	var target = $(this);
	 	var game_id = target.attr('data-gameid');
	 	var game_type = target.attr('data-gametype');

	 	if(game_type == 1){
	 		window.location = base_url + 'gamect/yn/' + game_id;
	 	}else if(game_type == 2){
	 		window.location = base_url + 'gamect/mul/' + game_id;
	 	}

	});

});

	// Đếm ngược ngày kết thúc game truyền thống
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
	 * { function_description }
	 *
	 * @param      {<type>}  heading  The heading
	 * @param      {<type>}  text     The text
	 * @param      {<type>}  icon     The icon
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