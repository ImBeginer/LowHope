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

	/**
	 * Tạo game mini yes no
	 */
	$('#create-game-btn-yes-no').on('click', function(event) {
	 	$ynGameObject = yesnogame;
	 	if (isValidData ($ynGameObject)) {
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
		 				url: base_url + 'creategame/createGameYN',
		 				type: 'POST',
		 				dataType: 'JSON',
		 				data: {game_title: game_title, end_date_time: end_date_time, price_bet:game_bitcoin_price},
		 			})
		 			.done(function(response) {
		 				if(response.create == 1){
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
							window.location.href = base_url + 'GameDetail/index/YN/' + response.game_id;
		 				}else if(response.create == 0){
		 					toatMessage('Warning', 'Hệ thống có lỗi xảy ra, vui lòng thử lại sau !','warning');
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
		 			url: base_url + 'creategame/createGameMulti',
		 			type: 'POST',
		 			dataType: 'JSON',
		 			data: {game_title_mul: game_title_mul, end_date_time:end_date_time, price_below:price_below, price_above:price_above},
		 		}).done(function(response) {
		 			console.log("success");
		 			if(response.create == 1){
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
		 				window.location.href = base_url + 'GameDetail/index/MC/' + response.game_id;
		 			}else if(response.create == 0){
		 				toatMessage('Warning', 'Có lỗi xảy ra, vui lòng thử lại sau !','warning');
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