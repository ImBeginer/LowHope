/**
 */
$(document).ready(function(){
  $('#notifi-list').DataTable({
    "language": {
      "lengthMenu": "Hiển thị _MENU_ bản ghi",
      "zeroRecords": "Không có dữ liệu",
      "info": "Trang _PAGE_ trên _PAGES_",
      "infoEmpty": "Không có bản ghi",
      "infoFiltered": "(Tìm kiếm từ _MAX_ dòng)",
      "search": "Tìm kiếm:",
      "loadingRecords": "Đang tải",
      "processing":     "Đang xử lý",
      "paginate": {
        "first":      "Trang đầu",
        "last":       "Trang cuối",
        "next":       "Trang kế",
        "previous":   "Trang trước" 
      },
    }        
  });
});


/**
 * search function to search title game by title
 * @return {[type]} [description]
 */
function search() {
	var search = $('#manager-search').val();
	var elems = document.querySelectorAll("#title");
    var items = document.querySelectorAll("#manager-noti");
    for (i = 0; i < elems.length; i++) {
        items[i].style.display = "block";
    }
    var i = 0;
    for (i = 0; i < elems.length; i++) {
        if (elems[i].textContent.indexOf(search) === -1) {
            items[i].style.display = "none";
        }
    }
}

/**
 * [showDetail description]
 * @param  {[type]} id [description]
 * @return {[type]}    [description]
 */
function showDetail(id) {
  for (var i = list.length - 1; i >= 0; i--) {
    if (list[i].NOTICE_ID == id) {
      noti_id = id;
      $('#notifi-title').val(list[i].TITLE);
      $('#notifi-content').val(list[i].CONTENT);
    }
  }
}

/**
 * [clearTextBox description]
 * @return {[type]} [description]
 */
function clearTextBox() {
  noti_id = -1;
  $('#notifi-title').val('');
  $('#notifi-content').val('');
}

/**
 * [description]
 * @param  {[type]} ){               ;} [description]
 * @return {[type]}     [description]
 */
$('button#notifi-remove-btn').on('click', function(){
  clearTextBox();
});

function updateNoti(title, content, noti_id) {
  $.ajax({
    url: base_url + 'EditNotification/updateNoti',
    type: 'POST',
    dataType: 'text',
    data: {
      id: noti_id,
      title : title,
      content : content
    },
  })
  .done(function(response) {
    console.log(response);
    if (response == 1) {
      toatMessage('Success', '<b>Cập nhật thông báo thành công!!</b>', 'success');
      location.reload();
    } else {
      toatMessage('Error', '<b>Có lỗi xảy ra! Vui lòng thử lại sau!</b>', 'error');
    }
  })
  .fail(function(response) {
    console.log("error");
  });
}

function deleteNoti(noti_id) {
  $.ajax({
    url: base_url + 'EditNotification/deleteNoti',
    type: 'POST',
    dataType: 'text',
    data: {
      id: noti_id
    },
  })
  .done(function(response) {
    console.log(response);
    if (response == 1) {
      toatMessage('Success', '<b>Xóa thông báo thành công!</b>', 'success');
      location.reload();
    } else {
      toatMessage('Error', '<b>Có lỗi xảy ra! Vui lòng thử lại sau!</b>', 'error');
    }
  })
  .fail(function(response) {
    console.log("error");
  });
}


function confirmDialog(title, content, noti_id, message, type) {
  $("#dialog-confirm").html('<p class="black medium-font-size"><i class="fa fa-exclamation-triangle black font-size-150" aria-hidden="true"></i>' + message + '</p>');
  $("#dialog-confirm").dialog({
    resizable: false,
    height: "auto",
    width: 400,
    modal: true,
    draggable: false,
    buttons: [
      {
        text: "Chắc chắn",
        "class": 'confirm-yes-btn btn medium-font-size',
        click: function() {
          $( this ).dialog( "close" );
          // sent request
          if (type == 'delete') {
            deleteNoti(noti_id);
          } else {
            updateNoti(title, content, noti_id);
          }
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
}


$('button#notifi-save-btn').on('click', function(){
  var title = $('#notifi-title').val();
  var content = $('#notifi-content').val();
  var message = '';
  if (noti_id == -1) {
    message = 'Bạn có chắc chắn muốn thêm mới nội dung thông báo này?';
  } else {
    message = 'Bạn có chắc chắn muốn cập nhật nội dung thông báo này?';    
  }
  confirmDialog(title, content, noti_id, message, 'update');
});  

$('button#notifi-delete-btn').on('click', function(){
  console.log('start');
  var message = '';
  if (noti_id == -1) {
    return;
  } else {
    message = 'Bạn có chắc chắn muốn xóa thông báo này?';    
  }
  confirmDialog('', '', noti_id, message, 'delete');
});  


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