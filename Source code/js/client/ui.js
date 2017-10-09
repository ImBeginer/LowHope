$(function() {
  $('#nav-game a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
  })
  // $('#tranditional-game').tab('show');
  // $('#mini-game').tab('show');

  $('[data-toggle="tooltip"]').tooltip();

  $currentYear = new Date().getFullYear();
  $currentYear -= 18;
    $("#dateOfBirth").datepicker({
    yearRange: '1947:' + $currentYear ,
    changeYear: true,
    changeMonth: true,
    dateFormat: "dd/mm/yy",
    dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
    monthNames: [ "Tháng riêng", "Tháng hai", "Tháng ba", "Tháng bốn", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai" ],
    monthNamesShort: [ "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12" ],
    showAnim: "clip"
  });

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
    // console.log ($id);
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
      // console.log ('there is no check box');
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
  function user_percent_in_de ($in_num, $de_num) {
    $percent_width = parseInt($('.percent-panel').css('width'), 10);

    $in_div = $('#increase');
    $de_div = $('#decrease');
    $in_user = $in_num;
    $de_user = $de_num;
    $total_user = parseInt($in_user) + parseInt($de_user);

    $in_div_width = Math.round(($percent_width * $in_user) / $total_user);
    $de_div_width = $percent_width - $in_div_width;

    $in_per_string = Math.round(($in_div_width / $percent_width) * 100);
    $de_per_string = 100 - $in_per_string;

    $in_div.css({'width': $in_div_width + 'px'});
    $de_div.css({'width': $de_div_width + 'px'});

    $('span.in-num-percent').text($in_per_string + '%');
    $('span.de-num-percent').text($de_per_string + '%');
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

  user_percent_in_de (280, 220);

});