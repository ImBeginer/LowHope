$(document).ready(function() {

	/************************CHECK DỮ LIỆU ĐẦU VÀO**************************/

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
   		$inputType = $inputTarget.attr('type');
   		$inputData = $inputTarget.val();
   		$regexFormat = new RegExp ($regex);
		// if ($inputType === 'number') {
		// 	// $inputData = parseInt ($inputData);
		// 	return /^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/.test($inputData);
		// } 
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
	   		} else if ($lower >= $upper) {
	   			$message += '<p class="error animated shake">Giá bitcoin trên phải lớn hơn dưới</p>';
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

	function passwordIsMatch  ($object) {
		$data = $object.confirmpass;
		if ($($data[0]).val() === $($data[1]).val()) {
			return true;
		} else {
			displayMessage ($object.panel, '<p class="error animated shake">Mật khẩu mới và mật khẩu xác nhận không chính xác</p>');
			return false;
		}
	}

	/**
	 * Người chơi đăng nhập vào hệ thống
	 */
	$('button#user-login').on('click', function() {
		event.preventDefault();

		$object = login;
	  	if (isValidData ($object)) {
			var email = $('#username').val();
			var pass = $('#userpassword').val();

			//Check email exist
			$.ajax({
				url: base_url + 'userct/checkUserExist',
				type: 'POST',
				dataType: 'JSON',
				data: {email: email, pass: pass},
			})
			.done(function(response) {
				if(response == 1){
					window.location.href = base_url + 'userct/home';
				}else if(response == 2){
					window.location.href = base_url + 'userct/home';
				}else if(response == 0){
					toatMessage('Warning', 'Sai password, vui lòng thử lại !', 'warning');
				}else if(response == 3){
					toatMessage('Info', 'Hệ thống đang gặp trục trặc !', 'info');
				}else if(response == 4){
					toatMessage('Warning', 'Email đã có người sử dụng !', 'warning');
				}
			})
			.fail(function(response) {
				console.log("checkUserExist: error");
			});
	  	} 
	});

	/**
	 * Đổi mật khẩu người dùng
	 */
	$('button#user-forgot-pass').on('click', function () {
	  	$object = forgotPass;
	  	if (isValidData ($object)) {
		    if (passwordIsMatch ($object)) {
		      	var email = $('#forgot-email').val(); 
		      	var pass = $('#confirmpass').val();
		      	var code =  $('#confirmcode').val();
		      	//alert(email + '-' + pass + '-' + code);
		      	$.ajax({
		      		url: base_url + 'userct/change_password',
		      		type: 'POST',
		      		dataType: 'JSON',
		      		data: {email: email, pass: pass, code: code}
		      	})
		      	.done(function(response) {
		      		if(response == 0){
		      			toatMessage('Warning', 'Mã xác nhận không đúng !', 'warning');
		      		}else if(response == 1){
		      			toatMessage('Success', 'Bạn đã đổi mật khẩu thành công !', 'success');
		      		}else if(response == 3){
		      			toatMessage('Warning', 'Mật khẩu mới không hợp lệ.', 'warning');
		      		}else{
		      			toatMessage('Warning', 'Hệ thống đang gặp trục trặc.', 'warning');
		      		}
		      	})
		      	.fail(function(response) {
		      		console.log("change_password: error");
		      	});
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
		      	//check email co ton tai khong
		      	$.ajax({
		      	  	url: base_url + 'userct/send_confirm_code',
		      	  	type: 'POST',
		      	  	dataType: 'html',
		      	  	data: {email: $emailVal},
		      	})
		      	.done(function(response) {
		      			var res = response.split('<br>');
		      			res = parseInt(res[res.length-1]);
			      	  	if(res == 1){
			      	  		toatMessage('Success', 'Mã xác nhận đã được gửi tới email, vui lòng kiểm tra.', 'success');
			      	  	}else if(res == 2){
			      	  		toatMessage('Info', 'Email không tồn tại.', 'info');
			      	  	}else{
			      	  		toatMessage('Warning', 'Hệ thống đang gặp trục trặc.', 'warning');
			      	  	}
		      	})
		      	.fail(function(response) {
		      	 	console.log("send_confirm_code: error");
		      	});
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
	 				console.log("updateUser: error");
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

		// $("#dialog-confirm-bet-game-tt").html('<p class="black medium-font-size"><i class="fa fa-exclamation-triangle black font-size-150" aria-hidden="true"></i>Bạn sẽ mất 100 point cho để đặt cược. Chơi không?</p>');
		// $("#dialog-confirm-bet-game-tt").dialog({
		// 	resizable: false,
		// 	height: "auto",
		// 	width: 400,
		// 	modal: true,
		// 	draggable: false,
		// 	buttons: [
		// 	{
		// 		text: "Xác nhận",
		// 		"class": 'confirm-yes-btn btn medium-font-size',
		// 		click: function() {
		// 			$( this ).dialog( "close" );
		// 		}
		// 	},
		// 	{
		// 		text: "Hủy bỏ",
		// 		"class": 'confirm-cancel-btn btn medium-font-size',
		// 		click: function() {
		// 			$( this ).dialog( "close" );
		// 		}
		// 	}
		// 	],
		// });

	 	var el = $('#point-input').val();
	 	var price_bet = parseFloat(el)|| 0;
	 	if(price_bet > 0 && /^\s*(?=.*[1-9])\d*(?:[^,;]+\.\d{1,2})?\s*$/.test(price_bet)){	
	 		$.ajax({
	 			url: base_url + 'gamect/log_game_tt',
	 			type: 'POST',
	 			dataType: 'JSON',
	 			data: {price_bet: price_bet},
	 		}).done(function(response) {
	 			if(response.result == 0){
	 				toatMessage('Warning','Đại ca! Có gì đó sai sai, ta nên thử lại sau...','warning');
	 				$('#point-input').val("");						
	 			}else if(response.result == 1){
	 				$('#point-input').val("");
	 				$('#user-point').text(response.user_point);
	 				toatMessage('Success','Bạn đã dự đoán thành công. <br>Cùng chờ có kết quả thôi nào !!!','success');
	 			}else if(response.result == 2) {
	 				toatMessage('Warning','Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !<br>(6,00 = 6.00 USD)','warning');
	 				$('#point-input').val("");
	 				$('#point-input').focus();
	 			}else if(response.result == 3){
	 				toatMessage('Info', 'Bạn không có đủ Point để đặt cược game này !<br>(Các game bạn tạo vẫn chưa kết thúc)','info');
	 			}else if(response.result == 4){
	 				toatMessage('Warning', 'Game hệ thống này đã đóng','warning');
	 			}
	 		}).fail(function(response) {
	 			console.log("log_game_tt: error");
	 		});
	 	}else {
	 		toatMessage('Warning','Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !<br>(6,00 = 6.00 USD)','warning');
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

	 		var isPrice = /^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/.test(game_bitcoin_price);
	 		if(end_date_time > current_date){
	 			if(isPrice){
		 			$.ajax({
		 				url: base_url + 'gameCT/createGameYN',
		 				type: 'POST',
		 				dataType: 'JSON',
		 				data: {game_title: game_title, end_date_time: end_date_time, price_bet:game_bitcoin_price},
		 			})
		 			.done(function(response) {
		 				if(response.create == 1){
		 					$('#user-point').text(response.user_point);
		 					if(!is_related_YN){
		 						listen_yes_no_game();
		 					}
		 					//send data to server
							$.ajax({
								url: 'http://localhost:3333/api/game/yngame',
								type: 'POST',
								dataType: 'JSON',
								data: {GAME_ID: response.game_id, END_DATE: end_date_time},
							})
							.done(function() {
								console.log("success");
							})
							.fail(function() {
								console.log("error");
							})
							.always(function() {
								console.log("complete");
							});

		 					$.toast({
							    heading: 'Success',
								text: 'Chúc mừng bạn đã tạo game thành công !<br>(Bạn sẽ được sang trang game trong giây lát)',
								showHideTransition: 'slide',
								icon: 'success',
								position: 'bottom-right',
								hideAfter: 5000,

							    afterHidden: function () {
							        location.href = base_url + 'gamect/yn/' + response.game_id;
							    }
							});
		 				}else if(response.create == 0){
		 					toatMessage('Warning', 'Hệ thống có lỗi xảy ra, vui lòng thử lại sau !','warning');
		 				}else if(response.create == 2){
		 					toatMessage('Info', 'Bạn không có đủ Point để tạo thêm game mới !<br>(Các game bạn tạo vẫn chưa kết thúc)','info');
		 				}else if(response.create == 3){
		 					toatMessage('Warning', 'Thời gian kết thúc game phải lớn hơn thời gian hiện tại','warning');
		 				}else if(response.create == 4){
		 					toatMessage('Warning', 'Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !<br>(6,00 = 6.00 USD)','warning');
		 				}
		 			})
		 			.fail(function(response) {
		 				console.log("createGameYN: error");
		 			});
	 			}else{
	 				toatMessage('Warning', 'Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !<br>(6,00 = 6.00 USD)','warning');
	 			}	 			
	 		}else{
	 			toatMessage('Warning', 'Thời gian kết thúc game phải lớn hơn thời gian hiện tại','warning');
	 		}
	 	}
	});

	/**
	 * Tạo game mini multi
	 */
	$('#create-game-btn-mul').on('click', function(event) {
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
		 		}).done(function(response) {
		 			console.log("success");
		 			if(response.create == 1){
		 				$('#user-point').text(response.user_point); 
		 				if(!is_related_MUL){
						    //Nhận thông báo sau khi kết thúc game multi
						    listen_multi_game();
						}
		 				//send data to server
						$.ajax({
							url: 'http://localhost:3333/api/game/multigame',
							type: 'POST',
							dataType: 'JSON',
							data: {GAME_ID: response.game_id, END_DATE: end_date_time},
						})
						.done(function() {
							console.log("success");
						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
						});

		 				$.toast({
						    heading: 'Success',
							text: 'Chúc mừng bạn đã tạo game thành công !<br>(Bạn sẽ được sang trang game trong giây lát)',
							showHideTransition: 'slide',
							icon: 'success',
							position: 'bottom-right',
							hideAfter: 5000,

						    afterHidden: function () {
						        location.href = base_url + 'gamect/mul/' + response.game_id;
						    }
						});
		 			}else if(response.create == 0){
		 				toatMessage('Warning', 'Có lỗi xảy ra, vui lòng thử lại sau !','warning');
		 			}else if(response.create == 2){
		 				toatMessage('Info', 'Bạn không có đủ Point để tạo thêm game mới !<br>(Các game bạn tạo vẫn chưa kết thúc)','info');
		 			}else if(response.create == 3){
		 				toatMessage('Warning', 'Thời gian kết thúc game phải lớn hơn thời gian hiện tại','warning');
		 			}else if(response.create == 4){
		 				toatMessage('Warning', 'Giá bitcoin phải lớn hơn 0 và tối đa 2 chữ số hàng thập phân !<br>(6,00 = 6.00 USD)','warning');
		 			}
		 		}).fail(function(response) {
		 			console.log("createGameMulti: error");
		 		});
	 		}else {
	 			toatMessage('Warning', 'Thời gian kết thúc game phải lớn hơn thời gian hiện tại','warning');
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
					if(!is_related_YN){
 						listen_yes_no_game();
 					}
					set_style_table_log_game();
					toatMessage('Success', 'Chúc mừng bạn đặt cược thành công !', 'success');
				}else if(response.result == 2){
					toatMessage('Warning', 'Bạn đã đặt cược game này !<br>Vui lòng chọn game khác để chơi.', 'warning');
				}else if(response.result == 3){
					toatMessage('Warning', 'Bạn không đủ point để chơi !!!<br> (Các game bạn tạo vẫn chưa kết thúc)', 'warning');
				}else if(response.result == 4){
					toatMessage('Warning', 'Bạn không được chơi game do mình tạo ra', 'warning');
				}else if(response.result == 5){
					toatMessage('Warning', 'Rất tiếc, game này đã đủ người chơi.<br>Vui lòng chọn game khác để chơi.', 'warning');
				}else if(response.result == 6){
					toatMessage('Warning', 'Rất tiếc, game này đã đóng.<br>Vui lòng chọn game khác để chơi.', 'warning');
				}
			}).fail(function(response) {
				console.log("log_game_yes_no: error");
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
					if(!is_related_MUL){
					    listen_multi_game();
					}
					set_style_table_log_game();
					toatMessage('Success', 'Chúc mừng bạn đặt cược thành công !', 'success');
				}else if(response.result == 2){
					toatMessage('Warning', 'Bạn đã đặt cược game này !<br>Vui lòng chọn game khác để chơi.', 'warning');
				}else if(response.result == 3){
					toatMessage('Warning', 'Bạn không đủ point để chơi !!!<br> (Các game bạn tạo vẫn chưa kết thúc)', 'warning');
				}else if(response.result == 4){
					toatMessage('Warning', 'Bạn không được chơi game do mình tạo ra', 'warning');
				}else if(response.result == 5){
					toatMessage('Warning', 'Rất tiếc, game này đã đủ người chơi.<br>Vui lòng chọn game khác để chơi.', 'warning');
				}else if(response.result == 5){
					toatMessage('Warning', 'Rất tiếc, game này đã đóng.<br>Vui lòng chọn game khác để chơi.', 'warning');
				}
			})
			.fail(function(response) {
				console.log("log_game_mul: error");
			});
		}
	});
});

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

if(typeof is_reward !== 'undefined'){
	if(is_reward){
		toatMessage('Success', 'Chúc mừng bạn đã được cộng 20 point vào tài khoản cho lần đăng nhập đầu tiên trong ngày.', 'success');
	}
}