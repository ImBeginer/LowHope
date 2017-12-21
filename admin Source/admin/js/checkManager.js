function blockManager(id) {
	$.ajax({
		url: base_url + 'ChangeManager/blockManager',
		type: 'POST',
		dataType: 'text',
		data: {
			id: id
		},
	})
	.done(function(response) {
		console.log(response);
		if (response == 1) {
			toatMessage('Success', '<b>Khóa người quản lý thành công!</b>', 'success');
			location.reload();
		} else {
			toatMessage('Error', '<b>Có lỗi xảy ra! Vui lòng thử lại sau!</b>', 'error');
		}
	})
	.fail(function(response) {
		console.log("error");
	});
}

function unblockManager(id) {
	$.ajax({
		url: base_url + 'ChangeManager/unblockManager',
		type: 'POST',
		dataType: 'text',
		data: {
			id: id
		},
	})
	.done(function(response) {
		console.log(response);
		if (response == 1) {
			toatMessage('Success', '<b>Mở khóa người quản lý thành công!</b>', 'success');
			location.reload();
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
	 * @param  {[type]} ) {               var value [description]
	 * @return {[type]}   [description]
	 */
  $('button.search-btn').on('click', function () {
    var value = $('#manager-search').val();
	var elems = document.querySelectorAll(".user-name");
    var items = document.querySelectorAll(".users");
    for (i = 0; i < elems.length; i++) {
        items[i].style.display = "list-item";
    }
    var i = 0;
    for (i = 0; i < elems.length; i++) {
        if (elems[i].textContent.toLowerCase().indexOf(value.toLowerCase()) === -1) {
            items[i].style.display = "none";
        }
    }

  });