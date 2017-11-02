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

  // $('#hot-mini-game-content').slick({
  //   infinite: true,
  //   slidesToShow: 8,
  //   slidesToScroll: 1,
  //   autoplay: true,
  //   autoplaySpeed: 2000,
  // });  
  
  $styleSheet = document.styleSheets[5];
  console.log ($styleSheet);
  $infinitySlide = $styleSheet.cssRules[0];
  console.log ($infinitySlide);
  $infinitySlide_From = $infinitySlide.cssRules[0];
  console.log ($infinitySlide_From);
  $infinitySlide_To = $infinitySlide.cssRules[1];
  console.log ($infinitySlide_To);  

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

  display_chat ();
  user_percent_mul (1, 0, 0);

});