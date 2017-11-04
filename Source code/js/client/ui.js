$(function() {
  $('#nav-game a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });

  $('[data-toggle="tooltip"]').tooltip();

  var elements = $("INPUT");
  for (var i = 0; i < elements.length; i++) {
    elements[i].oninvalid = function(e) {
      e.target.setCustomValidity("");
      if (!e.target.validity.valid) {
        switch (e.target.name) {
          default:
            e.target.setCustomValidity("Thông tin không được để trống");
          break;
          case 'userphone':
            if (e.target.validity.valueMissing) {
              e.target.setCustomValidity("Số điện thoại không thể trống");
            } else if (e.target.validity.patternMismatch) {
              e.target.setCustomValidity("Số điện thoại không hợp lệ");
            }
          break;
        }
      }
    };
    elements[i].oninput = function(e) {
      e.target.setCustomValidity("");
    };
  }

  $('#game-bitcoin-price-upper').on('change', function () {
    $('#game-bitcoin-price-between-lower').val($(this).val());
  });

  $('#game-bitcoin-price-lower').on('change', function () {
    $('#game-bitcoin-price-between-upper').val($(this).val());
  });  

  $currentYear = new Date().getFullYear();
  $("#game-date-yn, #game-date-mul").datepicker({
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

  function infinitySlideShow () {
    // tìm stylesheet có chứa rules
    $styleSheet = document.styleSheets[5];
    // chọn rules đầu tiên trong file stylesheet 
    $infinitySlide = $styleSheet.cssRules[0];
    // get from (0%) của rules
    $infinitySlide_From = $infinitySlide.cssRules[0];
    // get to (100%) của rules 
    $infinitySlide_To = $infinitySlide.cssRules[1];

    // get đối tượng parentHotItem
    $parentHotItem = $('#hot-mini-game-content');
    // get chiều rộng màn hình browser
    $bodyWidth = parseInt ($('body').css('width'), 10);
    // get số lượng hotItems
    $hotItems = $parentHotItem.children().length;
    // tính toán thời điểm kết thúc slideshow
    if ($hotItems > 9) {
      // get chiều rộng của 1 phần tử hotItems
      $widthOfHotItem = 150;
      // tính toán số phần tử hotItems tối đa có thể hiển thị trên màn hình
      $itemPerScreen = Math.floor ($bodyWidth / $widthOfHotItem);
      // chiều rộng của tất cả phần tử hotItems
      $widthOfAllItem = $hotItems * $widthOfHotItem;
      // thời điểm kết thúc slideshow
      $endSlideShow = $widthOfAllItem - ($itemPerScreen * $widthOfHotItem);
      // tỷ lệ thời gian kết thúc slideshow
      $endTime = Math.ceil($endSlideShow / 31);
      // đặt lại chiều rộng và thời gian cho đối tượng parentHotItem
      $parentHotItem.css('width', $widthOfAllItem);
      $parentHotItem.css('animation-duration', $endTime + 's');
      // get đối tượng style của rules (100%)
      $infinitySlide_To_Style = $infinitySlide_To.style;
      // add lại thuộc tính transform của rules (100%)
      $infinitySlide_To_Style.setProperty('transform', 'translate(' + (-1 * ($endSlideShow + 50)) + 'px)');
    }
  }

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
 * [get_notifi_id xử lý id dạng string trả về id của notification]
 * @param  {[String]} $string [VD: notifi-1]
 * @return {[String]}         [VD: 1]
 */
  function get_notifi_id ($string) {
    $id = $string.split('-');
    $id = $string[$string.length - 1];

    return $id;
  }

/**
 * [is_read nếu thông báo đã được đọc sẽ chuyển qua màu trắng, data-is-read="false"]
 * @param  {String}  $id [nhận vào id dạng string]
 */
  function is_read ($id = -1) {
    $circle_id = -1;
    if ($id !== -1) {
      $circle_id = get_notifi_id ($id);
      $('div#circle-read-' + $circle_id).css('background-color', 'initial');
      $('div#circle-read-' + $circle_id).attr('data-is-read', 'true');
    }
  }  
/**
 * [is_checked kiểm tra xem có checkbox nào được check chưa]
 * @return {Boolean} [trả về true nếu đã có checkbox được check, ngược lại trả về false]
 */
  function is_checked () {
    $checked = false;
    $('input.notifi-checkbox').each (function () {
      $id = $(this).attr('id');
      if (($('input#' + $id + ':checked').length) === 1) {
        $checked = true;
      }
    });  

    return $checked;  
  }

/**
 * [delete_notifi xóa đi những thông báo đã được checked]
 */
  function delete_notifi () {
    $('input.notifi-checkbox').each(function () {
      $id = $(this).attr('id');
      if (($('input#' + $id + ':checked').length) === 1) {
        $notifi_id = get_notifi_id ($id);
        $('#notifi-' + $notifi_id).remove();
      }
    });
    $('a#delete-btn').addClass('not-active');
  } 

/**
 * [init_delete_checker khởi tạo sự kiện xóa notifi]
 */
  function init_delete_checker () {
    if (is_checked ()) {
      $('a#delete-btn').removeClass ('not-active');
      $('a#delete-btn').on ('click', delete_notifi);
    } else {
      $('a#delete-btn').addClass ('not-active');
    }
  }
/**
 * [read_all_notifi đọc hết tất cả thông báo]
 */
  function read_all_notifi () {
    $('div.green-circle').each (function () {
      $green_circle_id = $(this).attr ('id');
      is_read ($green_circle_id);
    });

    $('a#read-all-btn').addClass ('not-active');
  }

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

  function user_percent_mul ($lower = 0, $between = 0, $upper = 0) {
    $percent_width = parseInt($('.game-mul.percent-panel').css('width'), 10) - 2;
    $total = $lower + $between + $upper;
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

  // select all notifi
  $('input#checkbox-all-box').on ('click', function () {
    // console.log ($(this).prop('checked'));
    $('input.notifi-checkbox').prop ('checked', $(this).prop('checked'));
  });

  // đọc tất notifi
  $('a#read-all-btn').on ('click', read_all_notifi);

  // xóa notifi
  $('input.notifi-checkbox').on ('click', init_delete_checker); 

  // đọc notifi
  $('h4.panel-title').on ('click', function (e) {
    is_read (e.currentTarget.id);
  });

  user_percent_in_de (0, 0);

  function display_chat () {
    $('#chat-btn').on('click', function () {
      $('#chat-panel').toggleClass('chat-active');
    });

    $('#chat-panel h5.chat-title span.close').on('click', function () {
      $('#chat-panel').toggleClass('chat-active');
    });
  }

// CHECK LOGIN MỚI 2/11
  function passwordIsMatch  ($object) {

    $data = $object.confirmpass;
    if ($($data[0]).val() === $($data[1]).val()) {
      return true;
    } else {
      displayMessage ($object.panel, '<p class="error animated shake">Mật khẩu mới và mật khẩu xác nhận không chính xác ĐCM</p>');
      return false;
    }
  }

  $('button#user-login').on('click', function () {
    $object = login;
    if (isValidData ($object)) {

      console.log ("OKE");

    }
  });

  $('button#user-forgot-pass').on('click', function () {
    $object = forgotPass;
    if (isValidData ($object)) {
      if (passwordIsMatch ($object)) {
        console.log ("OKE");
      }
    }
  });

  $('a.user-forgot-pass-form').on('click', function () {
    displayMessage('div#user-login-panel', '');
    $formDisplay = $('form[name=login-form]');
    if ($formDisplay.css('display') === 'block') {
      $formDisplay.animate({
      }, 100, function() {
        $formDisplay.css ('display', 'none');
        $('form[name=forgot-pass-form]').css ({
          'display': 'block',
          'opacity': 1
        });
        // $('form[name=forgot-pass-form]').addClass ('animated fadeIn');
      });
    }
  });

  $('a.user-login-form').on('click', function () {
    displayMessage('div#user-login-panel', '');
    $formDisplay = $('form[name=forgot-pass-form]')
    if ($formDisplay.css('display') === 'block') {
      $formDisplay.animate({
      }, 100, function() {
        $formDisplay.css ('display', 'none');
        $('form[name=login-form]').css ({
          'display': 'block',
          'opacity': 1
        });
        // $('form[name=login-form]').addClass ('animated fadeIn');
      });
    }

  });  

// /.CHECK LOGIN MỚI 2/11  

  display_chat ();
  user_percent_mul (2, 1, 0);
  
  infinitySlideShow ();
});