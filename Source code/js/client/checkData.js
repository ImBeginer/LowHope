var checkData = (function () {
  var isDataChecked = false;	
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

      console.log ($upper);

      if ($upper < 0 || $lower < 0) {
        $message += '<p class="error animated shake">Giá bitcoin trên khoảng hoặc dưới khoảng không thể âm</p>';
      } else if (isNaN($upper) || isNaN($lower)) {
        $message += '<p class="error animated shake">Giá bitcoin trên khoảng hoặc dưới khoảng không hợp lệ</p>'; 
      } else if ($upper > $lower) {
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

  function checkYNGame () {
    isDataChecked = false;
    $ynGameObject = yesnogame;
    isDataChecked = isValidData ($ynGameObject);
    if (isDataChecked) {
      $('#create-game').modal('hide');
    }   
  }

  $('button[name=update-btn]').on('click', function () {
  	isDataChecked = false;
    $userObject = user;
    isDataChecked = isValidData ($userObject);
    if (isDataChecked) {
      $('#user-update-info').modal('hide');
    }
  });  

  $('button[name=game-btn-yes-no]').on('click', checkYNGame);  

  $('button[name=game-btn-mul]').on('click', function () {
  	isDataChecked = false;
    $mulGameObject = mulGame;
    if (isValidData ($mulGameObject) && isPriceValid ($mulGameObject)) {
    	isDataChecked = true;
      $('#create-game').modal('hide');
    }
  });      

// ************************END CHECK DỮ LIỆU ĐẦU VÀO**************************

	return {
		isDataChecked: isDataChecked,
	};

})();