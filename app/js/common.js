$(function() {

	// Custom JS

});

$(function() {
	$(document).ready(function() {

		//E-mail Ajax Send
		$("#feedback").submit(function() { //Change
			var th = $(this);
			$.ajax({
				type: "POST",
				url: "../template/mail/mail.php", //Change
				data: th.serialize()
			}).done(function() {
				// alert("Благодарим за сообщение!");
				$("#feedback").fadeOut();
				$("#feed-alert").fadeIn();
				setTimeout(function() {
					th.trigger("reset");
				}, 500);
			});
			return false;
		});

	});
});
