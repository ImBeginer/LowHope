
  $('button.search-btn').on('click', function () {
    var value = $('#input-user-name').val();
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

  $('#all-manager-blocked-list button[name=btn-unban]').on ('click', function (event) {
    // ID của manager bị block
    user_id = event.currentTarget.value;
    console.log (event.currentTarget.value);

    $("#dialog-confirm").html('<p class="black medium-font-size"><i class="fa fa-exclamation-triangle black font-size-150" aria-hidden="true"></i>Bạn có chắc chắn muốn thăng cấp cho người chơi này ?</p>');
    $("#dialog-confirm").dialog({
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      draggable: false,
      buttons: [
        {
          text: "Xác nhận",
          "class": 'confirm-yes-btn btn medium-font-size',
          click: function() {
            $( this ).dialog( "close" );
            changePermission(user_id);
          }
        },
        {
          text: "Hủy bỏ",
          "class": 'confirm-cancel-btn btn medium-font-size',
          click: function() {
            $( this ).dialog( "close" );
          }
        }
      ],
    });
  });

  function changePermission(id) {
	$.ajax({
		url: base_url + 'AscendInRank/changePermission',
		type: 'POST',
		dataType: 'text',
		data: {
			id : id
		},
	})
	.done(function(response) {
		if (response == 1) {
			toatMessage('Success', '<b>Thăng cấp thành công!</b>', 'success');
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