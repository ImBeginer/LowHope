  	function endGame(id) {
		$.ajax({
			url: 'http://localhost:3333/api/game/systemgame',
			type: 'POST',
			dataType: 'text',
			data: {
				GAME_ID : id
			},
		})
		.done(function(response) {
		})
		.fail(function(response) {
			console.log("error");
		});
	}

	/**
	 * [changeDateTimeSysGame description]
	 * @param  {[type]} id [description]
	 * @return {[type]}    [description]
	 */
	function changeDateTimeSysGame(id) {
		var sys_date = $('#system-game-date').val().split('/');
		var sys_time = $('#sytem-game-time').val().split(':');;

		var end_date_time = (new Date(sys_date[2],sys_date[1]-1,sys_date[0], sys_time[0], sys_time[1])).getTime();


		$.ajax({
			url: base_url + 'SystemGameDemo/changePermission',
			type: 'POST',
			dataType: 'text',
			data: {
				id : id,
				date : end_date_time
			},
		})
		.done(function(response) {
			if (response == 1) {
				toatMessage('Success', '<b>Cập nhật thành công!</b>', 'success');
				endGame(id);
			} else {
				toatMessage('Error', '<b>Có lỗi xảy ra! Vui lòng thử lại sau!</b>', 'error');
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

	/**
	 * [description]
	 * @param  {[type]} ) {				changeDateTimeSysGame($(this).val());	} [description]
	 * @return {[type]}   [description]
	 */
	$('#btn-system-game').on('click', function () {
		// endGame($(this).val());
		changeDateTimeSysGame($(this).val());
	});