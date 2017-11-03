$(function () {

// ************************CHECK DỮ LIỆU ĐẦU VÀO**************************

  /**
   * [isEmpty kiểm tra xem input có rỗng hay không]
   * @param  {Object}  $inputTarget [dữ liệu input cần check]
   * @return {Boolean} [trả về true nếu rỗng ngược lại trả về false]
   */
  function isEmpty ($inputTarget = null) {
    // console.log ($inputTarget.val());
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
        $message += '<p class="error animated shake">' + $inputData['emptyInputMessage'][$inputID] + '</p>'; 
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
      if (!isValidFormat ($($panel + ' ' + '#' + $inputID), $inputFormat [$inputID])) {
        $message += '<p class="error animated shake">' + $invalidMessage [$inputID] + '</p>';
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

        return true;
      } else {

        return false;
      }
    } else {
      return false;
    }
  }

  function userCheckBox ($num = 30) {
    $totalBox = 0;
    $check = false;
    $userLists = ['#all-user-list', '#new-user-list', '#top-user-list'];

    for ($i = 0; $i < $userLists.length; $i++) {
      $allBox = $($userLists [$i] + ' ' + 'input.user-check-box');
      for ($j = 0; $j < $allBox.length; $j++) {
        if($($allBox [$j]).prop('checked')) {
          $totalBox++;
        }
      }
    }

    if (1 <= $totalBox && $totalBox <= 10) {
      return true;
    } else if ($totalBox > 10) {
      if (!$('input#notifi-radio').prop ('checked')) {
        displayMessage ($panel, '<p class="error animated shake">Số người gửi thông báo lớn hơn 30 người bạn chỉ được gửi theo phương thức thông báo</p>');
        return false;
      }
      return true;
    } else if ($totalBox === 0) {
      displayMessage ($panel, '<p class="error animated shake">Bạn chưa lựa chọn người gửi thông báo</p>');

      return false;
    } 
  }

  /**
   * [displayMessage hiển thị thông báo lỗi nếu input không hợp lệ]
   * @param  {String} $message [thông báo cần hiển thị]
   */
  function displayMessage ($panel = '', $message = '') {
    $($panel + ' .message').html ($message);
  }

  function removeMessage ($panel = '', $time = 2000) {
    setTimeout(function () {
      $($panel + ' div.message p').addClass('bounceOut');
    }, $time);
  }

  function passwordIsMatch  ($object) {

    $data = $object.confirmpass;
    if ($($data[0]).val() === $($data[1]).val()) {
      return true;
    } else {
      displayMessage ($object.panel, '<p class="error animated shake">Mật khẩu mới và mật khẩu xác nhận không chính xác ĐCM</p>');
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

  $('button#btn-send-notifi').on('click', function () {
    $object = notifi;
    if (isValidData ($object)) {
      if (userCheckBox (30)) {
        displayMessage ($object.panel, '<p class="valid animated shake">Dữ liệu hợp lệ</p>');
        removeMessage ($object.panel, 2000);
      }
    }
  }); 

  $('button.login-btn').on('click', function () {
    $object = login;
    if (isValidData ($object)) {
      displayMessage ($object.panel, '<p class="valid animated shake">Dữ liệu hợp lệ</p>');
      removeMessage ($object.panel, 2000);
    }
  });

  $('button[name=m-update-pass-btn]').on('click', function () {
    $object = password;
    if (isValidData ($object)) {
      if (passwordIsMatch($object)) {
        displayMessage ($object.panel, '<p class="valid animated shake">Dữ liệu hợp lệ</p>');
        removeMessage ($object.panel, 2000);
      }
    }
  });

  $('button[name=m-forgot-pass-btn]').on('click', function () {
    $object = forgotPass;
    if (isValidData ($object)) {
      if (passwordIsMatch($object)) {
        displayMessage ($object.panel, '<p class="valid animated shake">Dữ liệu hợp lệ</p>');
        removeMessage ($object.panel, 2000);
      }
    }
  });  

  $('button[name=m-update-info-btn]').on('click', function () {
    $object = managerInfo;
    if (isValidData ($object)) {
      displayMessage ($object.panel, '<p class="valid animated shake">Dữ liệu hợp lệ</p>');
      removeMessage ($object.panel, 2000);
    }
  });  

  $('button[name=m-create-yn-game]').on('click', function () {
    $object = yesnogame;
    if (isValidData ($object)) {
      displayMessage ($object.panel, '<p class="valid animated shake">Dữ liệu hợp lệ</p>');
      removeMessage ($object.panel, 2000);
    }
  });  

  $('button[name=m-create-mul-game]').on('click', function () {
    $object = mulGame;
    if (isValidData ($object) && isPriceValid ($object)) {
      displayMessage ($object.panel, '<p class="valid animated shake">Dữ liệu hợp lệ</p>');
      removeMessage ($object.panel, 2000);      
    }
  });  

  $('div.create-game-option ul#nav-game a.c-yn-game').on('click', function () {
    displayMessage ('div#yes-no-game', '');
  });

  $('div.create-game-option ul#nav-game a.c-mul-game').on('click', function () {
    displayMessage ('div#multi-choice-game', '');
  });    

// ************************END CHECK DỮ LIỆU ĐẦU VÀO**************************

});