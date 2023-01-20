(function($) {
	'use strict';

	$(window).scroll(function() {
		if ($(window).scrollTop() > 100) {
			$('.backtotop').addClass('active');
		} else {
			$('.backtotop').removeClass('active');
		}
	});

	$('.backtotop').click(function() {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});
})(jQuery);
