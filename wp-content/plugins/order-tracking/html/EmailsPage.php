<?php
	$Admin_Email = get_option("EWD_OTP_Admin_Email");
	$From_Name = get_option("EWD_OTP_From_Name");
	$Username = get_option("EWD_OTP_Username");
	$Port = get_option("EWD_OTP_Port");
	$Use_SMTP = get_option("EWD_OTP_Use_SMTP");
	$SMTP_Mail_Server = get_option("EWD_OTP_SMTP_Mail_Server");
	$Encryption_Type = get_option("EWD_OTP_Encryption_Type");
	$Email_Messages_Array = get_option("EWD_OTP_Email_Messages_Array");
    $Subject_Line = get_option("EWD_OTP_Subject_Line");
    $Tracking_Page = get_option("EWD_OTP_Tracking_Page");

    $Email_Messages_Array = get_option("EWD_OTP_Email_Messages_Array");
	if (!is_array($Email_Messages_Array)) {$Email_Messages_Array = array();}

	$UWPM_Banner_Time = get_option("EWD_OTP_UWPM_Ask_Time");
	if ($UWPM_Banner_Time == "") {$UWPM_Banner_Time = 0;}
?>
<div class="wrap">
<?php if (time() > $UWPM_Banner_Time) { ?>
	<div class="ewd-otp-uwpm-banner">
		<div class="ewd-otp-uwpm-banner-remove"><span>X</span></div>
		<div class="ewd-otp-uwpm-banner-icon">
			<img src='<?php echo EWD_OTP_CD_PLUGIN_URL . "/images/ewd-uwpm-icon.png"; ?>' />
		</div>
		<div class="ewd-otp-uwpm-banner-text">
			<div class="ewd-otp-uwpm-banner-title">
				<?php _e("Customize Your Emails With", 'order-tracking'); ?>
				<span>Ultimate WP Mail</span>
			</div>
			<ul>
				<li>Completely FREE</li>
				<li>Uses Shortcodes and Variables</li>
				<li>Integrates Seamlessly</li>
				<li>Custom Subject Lines For Each Email</li>
				<li>Visual Builder</li>
				<li>An Easy Email Experience</li>
			</ul>
			<div class="ewd-otp-clear"></div>
		</div>
		<div class="ewd-otp-uwpm-banner-buttons">
			<a class="ewd-otp-uwpm-banner-download-button" href='plugin-install.php?s=ultimate+wp+mail&tab=search&type=term'>
				<?php _e("Download Now", 'order-tracking'); ?>
			</a>
			<span class="ewd-otp-uwpm-banner-reminder"><? _e("Remind Me Later", 'order-tracking'); ?></span>
		</div>
		<div class="ewd-otp-clear"></div>
	</div>
<?php } ?>

<br />

<div class="ewd-otp-shortcode-reminder">
	<?php _e('<strong>REMINDER:</strong> If you\'re having trouble with sending emails, we recommend you use a plugin such as <a href="https://wordpress.org/plugins/wp-mail-smtp/" target="_blank">WP Mail SMTP</a> to configure your SMTP settings.', 'order-tracking'); ?>
</div>

<br />

<form method="post" action="admin.php?page=EWD-OTP-options&DisplayPage=Emails&OTPAction=EWD_OTP_UpdateEmailSettings">
<?php wp_nonce_field('EWD_OTP_Admin_Nonce', 'EWD_OTP_Admin_Nonce'); ?>

<br />

<div class="ewd-otp-admin-section-heading"><?php _e('Emails', 'order-tracking'); ?></div>

<table class="form-table">
<?php /* <tr>
<th scope="row">"Send-From" Email Address</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Email Address</span></legend>
	<label title='Email Address'><input type='text' name='admin_email' value='<?php echo $Admin_Email; ?>' /> </label><br />
	<p>The email address that order messages should be sent from to users.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">"Send-From" Name</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Email Address</span></legend>
	<label title='Email Address'><input type='text' name='from_name' value='<?php echo $From_Name; ?>' /> </label><br />
	<p>The name on the email account that order messages should be sent from to users.</p>
	</fieldset>
</td>
</tr> */ ?>

<tr>
<th scope="row">Subject Line</th>
<td>
    <fieldset><legend class="screen-reader-text"><span>Subject Line</span></legend>
    <label title='Subject Line'><input type='text' name='subject_line' value='<?php echo $Subject_Line; ?>' /> </label><br />
    <p>The subject line for your emails.</p>
    </fieldset>
</td>
</tr>

<tr>
<th scope="row">Admin Email</th>
<td>
    <fieldset><legend class="screen-reader-text"><span>Admin Email</span></legend>
    <label title='Admin Email'><input type='text' name='admin_email' value='<?php echo $Admin_Email; ?>' /> </label><br />
    <p>What email should customer note and customer order notifications be sent to, if they'd been set in the "Premium" area of the "Options" tab?</p>
    </fieldset>
</td>
</tr>

<tr>
<th scope="row">Status Tracking URL</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Status Tracking URL</span></legend>
	<label title='Tracking URL'><input type='text' name='tracking_page' value='<?php echo $Tracking_Page; ?>' /> </label><br />
	<p>The URL of your tracking page, required if you want to include a tracking link in your message body.</p>
	</fieldset>
</td>
</tr>

<tr class="ewd-otp-email-options-table-border ewd-otp-email-options-table-spacer">
	<th class="ewd-otp-admin-no-info-button"></th>
	<td></td>
</tr>
<tr class="ewd-otp-email-options-table-spacer">
	<th class="ewd-otp-admin-no-info-button"></th>
	<td></td>
</tr>

<tr>
<th scope="row">Email Messages</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Email Messages</span></legend>
	<table id='ewd-otp-email-messages-table'>
		<tr>
			<th class="ewd-otp-admin-no-info-button ewd-otp-admin-no-top-padding">Message Name</th>
			<th class="ewd-otp-admin-no-info-button ewd-otp-admin-no-top-padding">Message</th>
			<th class="ewd-otp-admin-no-info-button ewd-otp-admin-no-top-padding"></th>
		</tr>
		<?php
			$Counter = 0;
			if (!is_array($Email_Messages_Array)) {$Email_Messages_Array = array();}
			foreach ($Email_Messages_Array as $Email_Message_Item) {
				echo "<tr id='ewd-otp-email-message-" . $Counter . "'>";
					echo "<td><input class='ewd-otp-array-text-input' type='text' name='Email_Message_" . $Counter . "_Name' value='" . $Email_Message_Item['Name']. "'/></td>";
					echo "<td><textarea class='ewd-otp-array-textarea' name='Email_Message_" . $Counter . "_Body'>" . $Email_Message_Item['Message'] . "</textarea></td>";
					echo "<td><a class='ewd-otp-delete-message' data-messagenumber='" . $Counter . "'>Delete</a></td>";
				echo "</tr>";
				$Counter++;
			}
			echo "<tr><td colspan='2'><a class='ewd-otp-add-email' id='ewd-otp-add-email' data-nextid='" . $Counter . "'>&plus; " . __('ADD', 'order-tracking') . "</a></td></tr>";
		?>
	</table>
	<p>What should be in the messages sent to users? You can put [order-name], [order-number], [order-status], [order-notes], [customer-notes] and [order-time] into the message, to include current order name, order number, order status, public order notes or the time the order was updated.</p>
	<p>You can also use [tracking-link], [customer-name], [customer-id], [sales-rep] or the slug of a customer field enclosed in square brackets to include those fields in the email.</p>
	</fieldset>
</td>
</tr>

</table>

<?php /*
<div class="otp-email-advanced-settings">
<h3>SMTP Mail Settings</h3>
<table class="form-table">
<tr>
<th scope="row">Use SMTP</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Use SMTP</span></legend>
	<label title='Yes'><input type='radio' name='use_smtp' value='Yes' <?php if($Use_SMTP == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label>
	<label title='No'><input type='radio' name='use_smtp' value='No' <?php if($Use_SMTP == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
	<p>Should SMTP be used to send order emails?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">SMTP Mail Server Address</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>SMTP Mail Server Address</span></legend>
	<label title='Mail Server'><input type='text' name='smtp_mail_server' value='<?php echo $SMTP_Mail_Server; ?>' /> </label><br />
	<p>The server that should be connected to for SMTP email, if you're using SMTP to send your emails.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">SMTP Port</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>SMTP Port</span></legend>
	<label title='Port'><input type='text' name='port' value='<?php echo $Port; ?>' /> </label><br />
	<p>The port that should be used to send email.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">SMTP Username</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>SMTP Username</span></legend>
	<label title='Username'><input type='text' name='username' value='<?php echo $Username; ?>' /> </label><br />
	<p>The username for your email account, if you'd like to use SMTP to send your emails.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">SMTP Mail Password</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>SMTP Mail Password</span></legend>
	<label title='Email Password'><input type='password' name='admin_password' value='<?php echo $Admin_Password; ?>' /> </label><br />
	<p>The password for your email account, if you'd like to use SMTP to send your emails.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Encryption Type</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Encryption Type</span></legend>
	<label title='SSL'><input type='radio' name='encryption_type' value='ssl' <?php if($Encryption_Type == "ssl") {echo "checked='checked'";} ?> /> <span>SSL</span></label>
	<label title='TSL'><input type='radio' name='encryption_type' value='tsl' <?php if($Encryption_Type == "tsl") {echo "checked='checked'";} ?> /> <span>TSL</span></label><br />
	<p>What ecryption type should be used to send order emails?</p>
	</fieldset>
</td>
</tr>
</table>
</div>
<div class="otp-email-toggle-show" onclick="ShowMoreOptions()"><a> Show Advanced Settings... </a></div>
<div class="otp-email-toggle-hide" onclick="ShowMoreOptions()" style="display:none;"><a> Hide Advanced Settings... </a></div>
*/ ?>
<p class="submit"><input type="submit" name="Options_Submit" id="submit" class="button button-primary" value="Save Changes"  /></p></form>

</div>
