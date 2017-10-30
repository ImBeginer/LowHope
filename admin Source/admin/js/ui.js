$(function () {

  $('#user-nav a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  })

	$('[data-toggle="tooltip"]').tooltip();

	$('.setting').on('click', function () {
		$settingIcon = $('.setting i');

		$settingIcon.hasClass('rotate-setting') ? $settingIcon.removeClass ('rotate-setting') : $settingIcon.addClass ('rotate-setting');
	});

/**
 * [user_percent_in_de hiển thị phần trăm số người dự đoán giá bitcoin tăng hoặc giảm]
 */
  function user_percent_in_de ($in_num, $de_num) {
    $percent_width = parseInt($('.percent-panel').css('width'), 10) - 1;

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
