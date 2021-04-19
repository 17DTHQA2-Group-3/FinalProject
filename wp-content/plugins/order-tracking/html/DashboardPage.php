<?php
$Statuses_Array = get_option("EWD_OTP_Statuses_Array");

$Order_Information = get_option("EWD_OTP_Order_Information");

if (isset($_POST['hide_otp_review_box_hidden'])) {update_option('EWD_OTP_Hide_Dash_Review_Ask', sanitize_text_field($_POST['hide_otp_review_box_hidden']));}
$hideReview = get_option('EWD_OTP_Hide_Dash_Review_Ask');
$Ask_Review_Date = get_option('EWD_OTP_Ask_Review_Date');
if ($Ask_Review_Date == "") {$Ask_Review_Date = get_option("EWD_OTP_Install_Time") + 3600*24*4;}

$Sql = "SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Display='Yes' ORDER BY Order_Number LIMIT 0,10";
$myrows = $wpdb->get_results($Sql);
?>

<!-- START NEW DASHBOARD -->

<div id="ewd-otp-dashboard-content-area">

	<div id="ewd-otp-dashboard-content-left">

		<?php if ($EWD_OTP_Full_Version != "Yes" or get_option("EWD_OTP_Trial_Happening") == "Yes") {
			$premium_info = '<div class="ewd-otp-dashboard-new-widget-box ewd-widget-box-full">';
			$premium_info .= '<div class="ewd-otp-dashboard-new-widget-box-top">';
			$premium_info .= sprintf( __( '<a href="%s" target="_blank">Visit our website</a> to learn how to upgrade to premium.'), 'https://www.etoilewebdesign.com/premium-upgrade-instructions/' );
			$premium_info .= '</div>';
			$premium_info .= '</div>';

			echo apply_filters( 'ewd_dashboard_top', $premium_info, 'OTP', 'http://www.etoilewebdesign.com/plugins/order-tracking/#buy' );
		} ?>

		<div class="ewd-otp-dashboard-new-widget-box ewd-widget-box-full" id="ewd-otp-dashboard-support-widget-box">
			<div class="ewd-otp-dashboard-new-widget-box-top">Get Support<span id="ewd-otp-dash-mobile-support-down-caret">&nbsp;&nbsp;&#9660;</span><span id="ewd-otp-dash-mobile-support-up-caret">&nbsp;&nbsp;&#9650;</span></div>
			<div class="ewd-otp-dashboard-new-widget-box-bottom">
				<ul class="ewd-otp-dashboard-support-widgets">
					<li>
						<a href="https://www.youtube.com/watch?v=rMULYuPjVXU&list=PLEndQUuhlvSqa6Txwj1-Ohw8Bj90CIRl0" target="_blank">
							<img src="<?php echo plugins_url( '../images/ewd-support-icon-youtube.png', __FILE__ ); ?>">
							<div class="ewd-otp-dashboard-support-widgets-text">YouTube Tutorials</div>
						</a>
					</li>
					<li>
						<a href="https://wordpress.org/plugins/order-tracking/#faq" target="_blank">
							<img src="<?php echo plugins_url( '../images/ewd-support-icon-faqs.png', __FILE__ ); ?>">
							<div class="ewd-otp-dashboard-support-widgets-text">Plugin FAQs</div>
						</a>
					</li>
					<li>
						<a href="https://www.etoilewebdesign.com/support-center/?Plugin=OTP&Type=FAQs" target="_blank">
							<img src="<?php echo plugins_url( '../images/ewd-support-icon-documentation.png', __FILE__ ); ?>">
							<div class="ewd-otp-dashboard-support-widgets-text">Documentation</div>
						</a>
					</li>
					<li>
						<a href="https://www.etoilewebdesign.com/support-center/" target="_blank">
							<img src="<?php echo plugins_url( '../images/ewd-support-icon-forum.png', __FILE__ ); ?>">
							<div class="ewd-otp-dashboard-support-widgets-text">Get Support</div>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="ewd-otp-dashboard-new-widget-box ewd-widget-box-full" id="ewd-otp-dashboard-optional-table">
			<div class="ewd-otp-dashboard-new-widget-box-top">Recent Order Summary<span id="ewd-otp-dash-optional-table-down-caret">&nbsp;&nbsp;&#9660;</span><span id="ewd-otp-dash-optional-table-up-caret">&nbsp;&nbsp;&#9650;</span></div>
			<div class="ewd-otp-dashboard-new-widget-box-bottom">
				<table class='ewd-otp-overview-table wp-list-table widefat fixed striped posts'>
					<thead>
						<tr>
							<th><?php _e("Order Number", 'order-tracking'); ?></th>
							<th><?php _e("Name", 'order-tracking'); ?></th>
							<th><?php _e("Status", 'order-tracking'); ?></th>
							<th><?php _e("Updated", 'order-tracking'); ?></th>
						</tr>
					</thead>
					<tbody>
						 <?php
							if ($myrows) {
	  						  	foreach ($myrows as $Order) {
									echo "<tr id='Order" . $Order->Order_ID ."'>";
									echo "<td class='name column-name'>";
									echo "<strong>";
									echo "<a class='row-title' href='admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_Order_Details&Selected=Order&Order_ID=" . $Order->Order_ID ."' title='Edit " . $Order->Order_Number . "'>" . $Order->Order_Number . "</a></strong>";
									echo "</td>";
									echo "<td class='name column-name'>" . stripslashes($Order->Order_Name) . "</td>";
									echo "<td class='status column-status'>" . stripslashes($Order->Order_Status) . "</td>";
									echo "<td class='updated column-updated'>" . stripslashes($Order->Order_Status_Updated) . "</td>";
									echo "</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="ewd-otp-dashboard-new-widget-box <?php echo ( ($hideReview != 'Yes' and $Ask_Review_Date < time()) ? 'ewd-widget-box-two-thirds' : 'ewd-widget-box-full' ); ?>">
			<div class="ewd-otp-dashboard-new-widget-box-top">What People Are Saying</div>
			<div class="ewd-otp-dashboard-new-widget-box-bottom">
				<ul class="ewd-otp-dashboard-testimonials">
					<?php $randomTestimonial = rand(0,2);
					if($randomTestimonial == 0){ ?>
						<li id="ewd-otp-dashboard-testimonial-one">
							<img src="<?php echo plugins_url( '../images/dash-asset-stars.png', __FILE__ ); ?>">
							<div class="ewd-otp-dashboard-testimonial-title">"Great Plugin. Great Support!"</div>
							<div class="ewd-otp-dashboard-testimonial-author">- @pfernand</div>
							<div class="ewd-otp-dashboard-testimonial-text">The next best thing about finding a great plugin is finding a plugin with AWESOME support... <a href="https://wordpress.org/support/topic/great-plugin-great-support-644/" target="_blank">read more</a></div>
						</li>
					<?php }
					if($randomTestimonial == 1){ ?>
						<li id="ewd-otp-dashboard-testimonial-two">
							<img src="<?php echo plugins_url( '../images/dash-asset-stars.png', __FILE__ ); ?>">
							<div class="ewd-otp-dashboard-testimonial-title">"Order tracking made easy"</div>
							<div class="ewd-otp-dashboard-testimonial-author">- @vietnamsales</div>
							<div class="ewd-otp-dashboard-testimonial-text">That’s a wonderful plugin. Did I mention that customer service was fast, friendly and useful? <a href="https://wordpress.org/support/topic/order-tracking-made-easy/" target="_blank">read more</a></div>
						</li>
					<?php }
					if($randomTestimonial == 2){ ?>
						<li id="ewd-otp-dashboard-testimonial-three">
							<img src="<?php echo plugins_url( '../images/dash-asset-stars.png', __FILE__ ); ?>">
							<div class="ewd-otp-dashboard-testimonial-title">"Amazing plugin, Awesome Customer Support"</div>
							<div class="ewd-otp-dashboard-testimonial-author">- @diegoduarte</div>
							<div class="ewd-otp-dashboard-testimonial-text">The plugin is simple, but really amazing. It does everything is supposed to do. Five stars! <a href="https://wordpress.org/support/topic/amazing-plugin-awesome-customer-support/" target="_blank">read more</a></div>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>

		<?php if($hideReview != 'Yes' and $Ask_Review_Date < time()){ ?>
			<div class="ewd-otp-dashboard-new-widget-box ewd-widget-box-one-third">
				<div class="ewd-otp-dashboard-new-widget-box-top">Leave a review</div>
				<div class="ewd-otp-dashboard-new-widget-box-bottom">
					<div class="ewd-otp-dashboard-review-ask">
						<img src="<?php echo plugins_url( '../images/dash-asset-stars.png', __FILE__ ); ?>">
						<div class="ewd-otp-dashboard-review-ask-text">If you enjoy this plugin and have a minute, please consider leaving a 5-star review. Thank you!</div>
						<a href="https://wordpress.org/plugins/order-tracking/#reviews" class="ewd-otp-dashboard-review-ask-button" target="_blank">LEAVE A REVIEW</a>
						<form action="admin.php?page=EWD-OTP-options" method="post">
							<input type="hidden" name="hide_otp_review_box_hidden" value="Yes">
							<input type="submit" name="hide_otp_review_box_submit" class="ewd-otp-dashboard-review-ask-dismiss" value="I've already left a review">
						</form>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if ($EWD_OTP_Full_Version != "Yes" or get_option("EWD_OTP_Trial_Happening") == "Yes") { ?>
			<div class="ewd-otp-dashboard-new-widget-box ewd-widget-box-full" id="ewd-otp-dashboard-guarantee-widget-box">
				<div class="ewd-otp-dashboard-new-widget-box-top">
					<div class="ewd-otp-dashboard-guarantee">
						<div class="ewd-otp-dashboard-guarantee-title">14-Day 100% Money-Back Guarantee</div>
						<div class="ewd-otp-dashboard-guarantee-text">If you're not 100% satisfied with the premium version of our plugin - no problem. You have 14 days to receive a FULL REFUND. We're certain you won't need it, though.</div>
					</div>
				</div>
			</div>
		<?php } ?>

	</div> <!-- left -->

	<div id="ewd-otp-dashboard-content-right">

		<?php if ($EWD_OTP_Full_Version != "Yes" or get_option("EWD_OTP_Trial_Happening") == "Yes") { ?>
			<div class="ewd-otp-dashboard-new-widget-box ewd-widget-box-full" id="ewd-otp-dashboard-get-premium-widget-box">
				<div class="ewd-otp-dashboard-new-widget-box-top">Get Premium</div>

				<?php if ( get_option("EWD_OTP_Trial_Happening") == "Yes" ) { do_action( 'ewd_trial_happening', 'OTP' ); } ?>
				
				<div class="ewd-otp-dashboard-new-widget-box-bottom">
					<div class="ewd-otp-dashboard-get-premium-widget-features-title"<?php echo ( get_option("EWD_OTP_Trial_Happening") == "Yes" ? "style='padding-top: 20px;'" : ""); ?>>GET FULL ACCESS WITH OUR PREMIUM VERSION AND GET:</div>
					<ul class="ewd-otp-dashboard-get-premium-widget-features">
						<li>Set Up Sales Reps &amp; Customers</li>
						<li>Custom Fields</li>
						<li>WooCommerce Order Integration</li>
						<li>Advanced Display Options</li>
						<li>+ More</li>
					</ul>
					<a href="http://www.etoilewebdesign.com/plugins/order-tracking/#buy" class="ewd-otp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					<?php if (!get_option("EWD_OTP_Trial_Happening")) { 
						$trial_info = sprintf( __( '<a href="%s" target="_blank">Visit our website</a> to learn how to get a free 7-day trial of the premium plugin.'), 'https://www.etoilewebdesign.com/premium-upgrade-instructions/' );
						
						echo apply_filters( 'ewd_trial_button', $trial_info, 'OTP' );
					} ?>
				</div>
			</div>
		<?php } ?>

		<div class="ewd-otp-dashboard-new-widget-box ewd-widget-box-full">
			<div class="ewd-otp-dashboard-new-widget-box-top">Goes Great With</div>
			<div class="ewd-otp-dashboard-new-widget-box-bottom">
				<ul class="ewd-otp-dashboard-other-plugins">
					<li>
						<a href="https://wordpress.org/plugins/front-end-only-users/" target="_blank"><img src="<?php echo plugins_url( '../images/ewd-feup-icon.png', __FILE__ ); ?>"></a>
						<div class="ewd-otp-dashboard-other-plugins-text">
							<div class="ewd-otp-dashboard-other-plugins-title">Front-End Only Users</div>
							<div class="ewd-otp-dashboard-other-plugins-blurb">A user management and membership plugin that allows admins to restrict access to portions of their websites.</div>
						</div>
					</li>
					<li>
						<a href="https://wordpress.org/plugins/ultimate-faqs/" target="_blank"><img src="<?php echo plugins_url( '../images/ewd-ufaq-icon.png', __FILE__ ); ?>"></a>
						<div class="ewd-otp-dashboard-other-plugins-text">
							<div class="ewd-otp-dashboard-other-plugins-title">Ultimate FAQs</div>
							<div class="ewd-otp-dashboard-other-plugins-blurb">An easy-to-use FAQ plugin that lets you create, order and publicize FAQs, with many styles and options!</div>
						</div>
					</li>
				</ul>
			</div>
		</div>

	</div> <!-- right -->	

</div> <!-- ewd-otp-dashboard-content-area -->

<?php if ($EWD_OTP_Full_Version != "Yes" or get_option("EWD_OTP_Trial_Happening") == "Yes") { ?>
	<div id="ewd-otp-dashboard-new-footer-one">
		<div class="ewd-otp-dashboard-new-footer-one-inside">
			<div class="ewd-otp-dashboard-new-footer-one-left">
				<div class="ewd-otp-dashboard-new-footer-one-title">What's Included in Our Premium Version?</div>
				<ul class="ewd-otp-dashboard-new-footer-one-benefits">
					<li>Create &amp; Assign Orders to Sales Reps</li>
					<li>Create &amp; Tie Orders to Customers</li>
					<li>Custom Fields</li>
					<li>WooCommerce Order Integration</li>
					<li>Advanced Display &amp; Styling Options</li>
					<li>Front-End Customer Order Form</li>
					<li>Import/Export FAQs</li>
					<li>Set Up Status Locations</li>
					<li>Email Support</li>
				</ul>
			</div>
			<div class="ewd-otp-dashboard-new-footer-one-buttons">
				<a class="ewd-otp-dashboard-new-upgrade-button" href="http://www.etoilewebdesign.com/plugins/order-tracking/#buy" target="_blank">UPGRADE NOW</a>
			</div>
		</div>
	</div> <!-- ewd-otp-dashboard-new-footer-one -->
<?php } ?>	
<div id="ewd-otp-dashboard-new-footer-two">
	<div class="ewd-otp-dashboard-new-footer-two-inside">
		<img src="<?php echo plugins_url( '../images/ewd-logo-white.png', __FILE__ ); ?>" class="ewd-otp-dashboard-new-footer-two-icon">
		<div class="ewd-otp-dashboard-new-footer-two-blurb">
			At Etoile Web Design, we build reliable, easy-to-use WordPress plugins with a modern look. Rich in features, highly customizable and responsive, plugins by Etoile Web Design can be used as out-of-the-box solutions and can also be adapted to your specific requirements.
		</div>
		<ul class="ewd-otp-dashboard-new-footer-two-menu">
			<li>SOCIAL</li>
			<li><a href="https://www.facebook.com/EtoileWebDesign/" target="_blank">Facebook</a></li>
			<li><a href="https://twitter.com/EtoileWebDesign" target="_blank">Twitter</a></li>
			<li><a href="https://www.etoilewebdesign.com/blog/" target="_blank">Blog</a></li>
		</ul>
		<ul class="ewd-otp-dashboard-new-footer-two-menu">
			<li>SUPPORT</li>
			<li><a href="https://www.youtube.com/watch?v=rMULYuPjVXU&list=PLEndQUuhlvSqa6Txwj1-Ohw8Bj90CIRl0" target="_blank">YouTube Tutorials</a></li>
			<li><a href="https://www.etoilewebdesign.com/support-center/?Plugin=OTP&Type=FAQs" target="_blank">Documentation</a></li>
			<li><a href="https://www.etoilewebdesign.com/support-center/" target="_blank">Get Support</a></li>
			<li><a href="https://wordpress.org/plugins/order-tracking/#faq" target="_blank">FAQs</a></li>
		</ul>
	</div>
</div> <!-- ewd-otp-dashboard-new-footer-two -->

<!-- END NEW DASHBOARD -->
