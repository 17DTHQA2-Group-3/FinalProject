		<div class="wrap">
		<div class="Header"><h2><?php _e("Status Tracking Settings", 'order-tracking') ?></h2></div>

		<?php if ($EWD_OTP_Full_Version != "Yes" or get_option("EWD_OTP_Trial_Happening") == "Yes") { ?>
			<?php $display_trial_banner = ( time() < 1575331200 and ( time() > 1574917200 or ( time() > 1574467200 and get_option('EWD_URP_Install_Time') < time() - 7*24*3600) ) ); ?>
			<div class="ewd-otp-dashboard-new-upgrade-banner">
				<div class="ewd-otp-dashboard-banner-icon"></div>
				<div class="ewd-otp-dashboard-banner-buttons">
					<a class="ewd-otp-dashboard-new-upgrade-button" href="http://www.etoilewebdesign.com/plugins/order-tracking/#plugin-sales-plans" target="_blank">UPGRADE NOW</a>
				</div>
				<div class="ewd-otp-dashboard-banner-text <?php echo ( $display_trial_banner ? 'ewd-otp-bf-banner' : '' ); ?>">
					<!-- Start Black Friday -->
					<?php if ( $display_trial_banner ) { ?>
					<div class="ewd-otp-dashboard-banner-black-friday-text">
						<div class="ewd-otp-dashboard-banner-black-friday-title">
							30% OFF PREMIUM FOR BLACK FRIDAY!
						</div>
						<div class="ewd-otp-dashboard-banner-black-friday-brief">
							Upgrade now to receive this great discount. No coupon code necessary. November 28th to December 2nd EST.
						</div>
						<div class="ewd-otp-dashboard-banner-black-friday-brief-mobile">
							November 28th to December 2nd EST.
						</div>
					</div>
					<?php } ?>
					<!-- End Black Friday -->
					<div class="ewd-otp-dashboard-banner-title">
						GET FULL ACCESS WITH OUR PREMIUM VERSION
					</div>
					<div class="ewd-otp-dashboard-banner-brief">
						Track the status of your order simply and effectively
					</div>
				</div>
			</div>
		<?php } ?>