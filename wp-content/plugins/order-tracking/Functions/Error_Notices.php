<?php
/* Add any update or error notices to the top of the admin page */
function EWD_OTP_Error_Notices(){
    global $ewd_otp_message;
	if (isset($ewd_otp_message)) {
		if (isset($ewd_otp_message['Message_Type']) and $ewd_otp_message['Message_Type'] == "Update") {echo "<div class='updated'><p>" . $ewd_otp_message['Message'] . "</p></div>";}
		if (isset($ewd_otp_message['Message_Type']) and $ewd_otp_message['Message_Type'] == "Error") {echo "<div class='error'><p>" . $ewd_otp_message['Message'] . "</p></div>";}
	}

	if( get_transient( 'ewd-otp-admin-install-notice' ) ){ ?>
		<div class="updated notice is-dismissible">
            <p>Head over to the <a href="admin.php?page=EWD-OTP-options">Order Tracking Dashboard</a> to get started using the plugin!</p>
        </div>

        <?php
        delete_transient( 'ewd-otp-admin-install-notice' );
	}

	$Ask_Review_Date = get_option('EWD_OTP_Ask_Review_Date');
	if ($Ask_Review_Date == "") {$Ask_Review_Date = get_option("EWD_OTP_Install_Time") + 3600*24*4;}

	if ($Ask_Review_Date < time() and get_option("EWD_OTP_Install_Time") < time() - 3600*24*4) {

		global $pagenow;
		if($pagenow != 'post.php' && $pagenow != 'post-new.php'){ ?>

			<div class='notice notice-info is-dismissible ewd-otp-main-dashboard-review-ask' style='display:none'>
				<div class='ewd-otp-review-ask-plugin-icon'></div>
				<div class='ewd-otp-review-ask-text'>
					<p class='ewd-otp-review-ask-starting-text'>Enjoying using the Status Tracking plugin?</p>
					<p class='ewd-otp-review-ask-feedback-text otp-hidden'>Help us make the plugin better! Please take a minute to rate the plugin. Thanks!</p>
					<p class='ewd-otp-review-ask-review-text otp-hidden'>Please let us know what we could do to make the plugin better!<br /><span>(If you would like a response, please include your email address.)</span></p>
					<p class='ewd-otp-review-ask-thank-you-text otp-hidden'>Thank you for taking the time to help us!</p>
				</div>
				<div class='ewd-otp-review-ask-actions'>
					<div class='ewd-otp-review-ask-action ewd-otp-review-ask-not-really ewd-otp-review-ask-white'>Not Really</div>
					<div class='ewd-otp-review-ask-action ewd-otp-review-ask-yes ewd-otp-review-ask-green'>Yes!</div>
					<div class='ewd-otp-review-ask-action ewd-otp-review-ask-no-thanks ewd-otp-review-ask-white otp-hidden'>No Thanks</div>
					<a href='https://wordpress.org/support/plugin/order-tracking/reviews/' target='_blank'>
						<div class='ewd-otp-review-ask-action ewd-otp-review-ask-review ewd-otp-review-ask-green otp-hidden'>OK, Sure</div>
					</a>
				</div>
				<div class='ewd-otp-review-ask-feedback-form otp-hidden'>
					<div class='ewd-otp-review-ask-feedback-explanation'>
						<textarea></textarea>
						<br>
						<input type="email" name="feedback_email_address" placeholder="<?php _e('Email Address', 'order-tracking'); ?>">
					</div>
					<div class='ewd-otp-review-ask-send-feedback ewd-otp-review-ask-action ewd-otp-review-ask-green'>Send Feedback</div>
				</div>
				<div class='ewd-otp-clear'></div>
			</div>

			<?php
		}
	}
}



