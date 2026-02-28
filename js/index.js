$(document).ready(function (e) {
	setInterval(function () {
		var actual = $(".banners .imagen").last();
		$(actual).fadeOut({
			duration: 1000,
			complete: function () {
				$(actual).remove();
				$(".banners").prepend(actual);
				$(actual).fadeIn(1);
			}
		});
	}, 5000);
});