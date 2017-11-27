$(function () {

  $('#user-nav a, #nav-game a, #nav-game-list a, #nav-change-gift a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
  
  $('[data-toggle="tooltip"]').tooltip();

	$('.setting').on('click', function () {
		$settingIcon = $('.setting i');

		$settingIcon.hasClass('rotate-setting') ? $settingIcon.removeClass ('rotate-setting') : $settingIcon.addClass ('rotate-setting');
	});

  $('#game-bitcoin-price-upper').on('change', function () {
    $('#game-bitcoin-price-between-lower').val($(this).val());
  });

  $('#game-bitcoin-price-lower').on('change', function () {
    $('#game-bitcoin-price-between-upper').val($(this).val());
  });

  $('#nav-icon1').click(function(){
    $(this).toggleClass('open');
    if ($(this).hasClass('open')) {
      $('div.sidebar').addClass('d-blk');
    } else {
      $('div.sidebar').removeClass('d-blk');
    }
  });

  $currentYear = new Date().getFullYear();
  $("div.create-game-option #game-date-yn, div.create-game-option #game-date-mul").datepicker({
    yearRange: $currentYear + ':' + ($currentYear + 3) ,
    changeYear: true,
    changeMonth: true,
    dateFormat: "dd/mm/yy",
    dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
    monthNames: [ "Tháng riêng", "Tháng hai", "Tháng ba", "Tháng bốn", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai" ],
    monthNamesShort: [ "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12" ],
    showAnim: "clip",
    minDate: new Date()
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

/********** MỚI 6/11/2017 ************/
  $('#all-manager-list button[name=btn-ban]').on ('click', function (event) {
    // ID của manager bị block
    $blockID = event.currentTarget.value;
    console.log (event.currentTarget.value);

    $("#dialog-confirm").html('<p class="black medium-font-size"><i class="fa fa-exclamation-triangle black font-size-150" aria-hidden="true"></i>Bạn có chắc chắn muốn block manager này ?</p>');
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
            getManagerBlockID ($blockID);
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

  $('#all-manager-blocked-list button[name=btn-unban]').on ('click', function (event) {
    // ID của manager bị block
    $unblockID = event.currentTarget.value;
    console.log (event.currentTarget.value);

    $("#dialog-confirm").html('<p class="black medium-font-size"><i class="fa fa-exclamation-triangle black font-size-150" aria-hidden="true"></i>Bạn có chắc chắn muốn bỏ block manager này ?</p>');
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
            getManagerUnblockID ($unblockID);
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

  $('#change-gift-panel button[name=gift-tradi-btn]').on ('click', function (event) {
    $("#dialog-confirm").html('<div class="change-gift-pass-panel"><span class="black admin-confirm"><i class="fa fa-exclamation" aria-hidden="true"></i>Xác nhận danh tính</span><input type="password" name="admin-pass" placeholder="Mật khẩu" id="admin-pass" class="form-control black"></div>');
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
            console.log ('ADMIN EMAIL TRADI: ' + $('input#admin-email').val());
            console.log ('ADMIN PASS TRADI: ' +  $('input#admin-pass').val());
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

  $('.game-func p.tag.active-func a.deactive-game').on ('click', function (event) {
    $gameId = $(this).attr('id');
    $("#dialog-confirm").html('<div class="change-gift-pass-panel"><span class="black admin-confirm"><i class="fa fa-exclamation" aria-hidden="true"></i>Xác nhận danh tính</span><input type="password" name="admin-pass" placeholder="Mật khẩu" id="admin-pass" class="form-control black"></div>');
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
            console.log ('ADMIN EMAIL TRADI: ' + $('input#admin-email').val());
            console.log ('ADMIN PASS TRADI: ' +  $('input#admin-pass').val());
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

  $('#change-gift-panel button[name=gift-yn-btn]').on ('click', function (event) {
    $("#dialog-confirm").html('<div class="change-gift-pass-panel"><span class="black admin-confirm"><i class="fa fa-exclamation" aria-hidden="true"></i>Xác nhận danh tính</span><input type="text" name="admin-email" placeholder="Tài khoản email" id="admin-email" class="form-control black"><input type="password" name="admin-pass" placeholder="Mật khẩu" id="admin-pass" class="form-control black"></div>');
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
            console.log ('ADMIN EMAIL YN: ' + $('input#admin-email').val());
            console.log ('ADMIN PASS YN: ' +  $('input#admin-pass').val());
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

  $('#change-gift-panel button[name=gift-mul-btn]').on ('click', function (event) {
    $("#dialog-confirm").html('<div class="change-gift-pass-panel"><span class="black admin-confirm"><i class="fa fa-exclamation" aria-hidden="true"></i>Xác nhận danh tính</span><input type="text" name="admin-email" placeholder="Tài khoản email" id="admin-email" class="form-control black"><input type="password" name="admin-pass" placeholder="Mật khẩu" id="admin-pass" class="form-control black"></div>');
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
            console.log ('ADMIN EMAIL MUL: ' + $('input#admin-email').val());
            console.log ('ADMIN PASS MUL: ' +  $('input#admin-pass').val());
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

  $('#crud-notifi button[name=notifi-create-btn]').on ('click', function (event) {
    $("#dialog-confirm").html('<p class="black medium-font-size"><i class="fa fa-exclamation-triangle black font-size-150" aria-hidden="true"></i>Nếu thông báo này đã tồn tại nội dung của thông báo sẽ được cập nhật lại. Bạn có chắc chắn muốn lưu ?</p>');
    $("#dialog-confirm").dialog({
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      draggable: false,
      buttons: [
        {
          text: "Lưu",
          "class": 'confirm-yes-btn btn medium-font-size',
          click: function() {
            $( this ).dialog( "close" );
            console.log('TIÊU ĐỀ: ' + $('input#notifi-title').val());
            console.log('NỘI DUNG:  ' + $('input#notifi-content').val());
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

  $('#crud-notifi button[name=notifi-delete-btn]').on ('click', function (event) {
    $("#dialog-confirm").html('<p class="black medium-font-size"><i class="fa fa-exclamation-triangle black font-size-150" aria-hidden="true"></i>Bạn có chắc chắn muốn xóa nội dung thông báo này ?</p>');
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
            console.log('TIÊU ĐỀ: ' + $('input#notifi-title').val());
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

  function getManagerBlockID ($blockID) {
    console.log ('MANAGER ID BỊ BLOCK: ' + $blockID);
  }

  function getManagerUnblockID ($unblockID) {
    console.log ('MANAGER ID BỎ BLOCK: ' + $unblockID);
  }  
/********** MỚI 6/11/2017 ************/

/**
 * [select_all chọn tối đa 30 user trong user-list]
 * @param  {Number}  $numBox      [số lượng tối đa user được chọn]
 * @param  {String}  $parentPanel [panel chứa user-list]
 * @param  {Boolean} $isChecked   [box select all user có được check hay là không]
 */
  function select_all ($numBox = 30, $parentPanel = '', $isChecked = false) {
    $allCheckBox = $('#' + $parentPanel + ' ul.user-list li input.user-check-box');
    $numBox = $allCheckBox.length < $numBox ? $allCheckBox.length : $numBox;
    for ($i = 0; $i < $numBox; $i++) {
      $($allCheckBox [$i]).prop('checked', $isChecked);
    }
  }

  $('input[name=all-users], input[name=new-users]').on('click', function () {
    $parentPanel = $(this).attr("data-panel");
    $isChecked = $(this).prop('checked');
    select_all (30, $parentPanel, $isChecked);
  });

  $('input[name=top-users]').on('click', function () {
    $parentPanel = $(this).attr("data-panel");
    $isChecked = $(this).prop('checked');
    select_all (3, $parentPanel, $isChecked);
  });

  user_percent_in_de (280, 220);

});
