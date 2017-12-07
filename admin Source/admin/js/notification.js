var pusher = new Pusher('711b956416d9d15de4b8', {
  cluster: 'ap1',
  encrypted: true
});

function getInformationById(id) {
	$.ajax({
		url: base_url + 'Notification/getInforById',
		type: 'POST',
		dataType: 'JSON',
		data: {
			id: id
		},
	})
	.done(function(response) {
		console.log(response);
		var name = response.USER_NAME;
		var phone = response.PHONE_NUMBER;
		var address = response.ADDRESS;
		var email = response.EMAIL;
		var win_no = response.WIN;
		var total = response.TOTAL;
		var lose_no = total - win_no;
		var champion = response.CHAMPION;
		console.log(champion);
		$('#name').text(name);
		$('#phone').text(phone);
		$('#address').text(address);
		$('#email').text(email);
		$('#champions').text(champion);
		$('#win').text(win_no);
		$('#lose').text(lose_no);
		$('#sum').text(total);
      	user_percent_in_de(win_no, lose_no);
	})
	.fail(function(response) {
		console.log("error");
	});
}

function checkDuplicate(list, id) {
	for (var i = 0; i < list.length; i++) {
		if (list[i] == id) {
			return false;
		}
	}
	return true;
}

function checkToSentNoti() {
	var list = [];
	$array1 = $('#all-user-list input.user-check-box');
    $array2 = $('#new-user-list input.user-check-box');
    // $array3 = $('#top-user-list input.user-check-box');
	for (var i = 0; i < $array1.length; i++) {
	  if ($array1[i].checked) {
	  	if (checkDuplicate(list, $array1[i].value)) {
	  		list.push($array1[i].value);
	  	} else {
	  		console.log('duplicate at ' + $array1[i].value);
	  	}
	  }
	}
	for (var i = 0; i < $array2.length; i++) {
	  if ($array2[i].checked) {
	  	if (checkDuplicate(list, $array2[i].value)) {
	  		list.push($array2[i].value);
	  	} else {
	  		console.log('duplicate at ' + $array2[i].value);
	  	}
	  }
	}

	var id = $('#notifi-form').val();
	if (id == 0) {
		alert('Bạn cần lựa chọn thông báo trước khi gửi!');
		return;
	}
	console.log(list);

	// check type of message
	if ($('#notifi-radio').is(":checked")) {
		// notification
		sentNoti(list, id);
	} else if ($('#mail-radio').is(":checked")) {

	} else {
		sentNoti(list, id);
	}
}


function sentNoti (list, id) {
	$.ajax({
		url: base_url + 'Notification/sentNotification',
		type: 'POST',
		dataType: 'text',
		data: {
			userId: list,
			noticeId: id
		},
	})
	.done(function(response) {
		if (response == 1) {
			toatMessage('Success', '<b>Gửi thông báo thành công!</b>', 'success');
		} else {
			toatMessage('Error', '<b>Có lỗi trong quá trình gửi thông báo! Vui lòng thử lại sau!</b>', 'error');
		}
	})
	.fail(function(response) {
		console.log("error");
	});
}

function selectNoti () {
	var id = $('#notifi-form').val();
	if (id == 0) {
		$('#notifi-panel').text('');
		return;
	}
	for (var i = 0; i < listNoti.length; i++) {
		if (listNoti[i]['NOTICE_ID'] == id) {
			$('#notifi-panel').text(listNoti[i]['CONTENT']);
			return;
		}
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

var channel_test = pusher.subscribe('test_channel');
channel_test.bind('test_event', function(data) {
  alert(data.message);
});

/**
 * search function to search title game by title
 * @return {[type]} [description]
 */
function search() {
	var search = $('#user-search').val();
	var elems = document.querySelectorAll("#user-name");
    var items = document.querySelectorAll("#users");
    for (i = 0; i < elems.length; i++) {
        items[i].style.display = "block";
    }
    // var search = document.getElementById("search").value;
    var i = 0;
    for (i = 0; i < elems.length; i++) {
        if (elems[i].textContent.toLowerCase().indexOf(search.toLowerCase()) === -1) {
            items[i].style.display = "none";
        }
    }
}

$('input#user-search').on('keydown', function(e) {
    if (e.which == 13) {
        search();
    }
});

$('#btn-add-notifi').on('click', function(e) {
   window.location.href = base_url + 'EditNotification';
});

/**
 * [user_percent_in_de hiển thị phần trăm số người dự đoán giá bitcoin tăng hoặc giảm]
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
  