$(function () {

	$('[data-toggle="tooltip"]').tooltip();

	$('.setting').on('click', function () {
		$settingIcon = $('.setting i');

		$settingIcon.hasClass('rotate-setting') ? $settingIcon.removeClass ('rotate-setting') : $settingIcon.addClass ('rotate-setting');
	});

});
