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

  $('button#btn-send-notifi').on('click', function () {
    $notification = notifi;
    if (isValidData ($notification)) {
      if (userCheckBox (30)) {
        displayMessage ('.send-notifi-panel', '<p class="valid animated shake">Dữ liệu hợp lệ</p>');
        removeMessage ('.send-notifi-panel', 2000);
        console.log ('NOTIFI OKE');
      }

    }
  }); 



// ************************END CHECK DỮ LIỆU ĐẦU VÀO**************************

});