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

});
