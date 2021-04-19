jQuery(document).ready(function($) {
	jQuery('.ewd-otp-main-dashboard-review-ask').css('display', 'block');

  jQuery(document).on('click', '.ewd-otp-main-dashboard-review-ask .notice-dismiss', function(event) {
    var data = 'Ask_Review_Date=7&action=ewd_otp_hide_review_ask';
    jQuery.post(ajaxurl, data, function() {});
  });

	jQuery('.ewd-otp-review-ask-yes').on('click', function() {
		jQuery('.ewd-otp-review-ask-feedback-text').removeClass('otp-hidden');
		jQuery('.ewd-otp-review-ask-starting-text').addClass('otp-hidden');

		jQuery('.ewd-otp-review-ask-no-thanks').removeClass('otp-hidden');
		jQuery('.ewd-otp-review-ask-review').removeClass('otp-hidden');

		jQuery('.ewd-otp-review-ask-not-really').addClass('otp-hidden');
		jQuery('.ewd-otp-review-ask-yes').addClass('otp-hidden');

		var data = 'Ask_Review_Date=7&action=ewd_otp_hide_review_ask';
    	jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.ewd-otp-review-ask-not-really').on('click', function() {
		jQuery('.ewd-otp-review-ask-review-text').removeClass('otp-hidden');
		jQuery('.ewd-otp-review-ask-starting-text').addClass('otp-hidden');

		jQuery('.ewd-otp-review-ask-feedback-form').removeClass('otp-hidden');
		jQuery('.ewd-otp-review-ask-actions').addClass('otp-hidden');

		var data = 'Ask_Review_Date=1000&action=ewd_otp_hide_review_ask';
    	jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.ewd-otp-review-ask-no-thanks').on('click', function() {
		var data = 'Ask_Review_Date=1000&action=ewd_otp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});

        jQuery('.ewd-otp-main-dashboard-review-ask').css('display', 'none');
	});

	jQuery('.ewd-otp-review-ask-review').on('click', function() {
		jQuery('.ewd-otp-review-ask-feedback-text').addClass('otp-hidden');
		jQuery('.ewd-otp-review-ask-thank-you-text').removeClass('otp-hidden');

		var data = 'Ask_Review_Date=1000&action=ewd_otp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.ewd-otp-review-ask-send-feedback').on('click', function() {
		var Feedback = jQuery('.ewd-otp-review-ask-feedback-explanation textarea').val();
		var EmailAddress = jQuery('.ewd-otp-review-ask-feedback-explanation input[name="feedback_email_address"]').val();
		var data = 'Feedback=' + Feedback + '&EmailAddress=' + EmailAddress + '&action=ewd_otp_send_feedback';
        jQuery.post(ajaxurl, data, function() {});

        var data = 'Ask_Review_Date=1000&action=ewd_otp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});

        jQuery('.ewd-otp-review-ask-feedback-form').addClass('otp-hidden');
        jQuery('.ewd-otp-review-ask-review-text').addClass('otp-hidden');
        jQuery('.ewd-otp-review-ask-thank-you-text').removeClass('otp-hidden');
	});
});