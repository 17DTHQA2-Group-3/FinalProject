<?php 
	$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
	$Email_Messages_Array = get_option("EWD_OTP_Email_Messages_Array");
	if (!is_array($Statuses_Array)) {$Statuses_Array = array();}
	if (!is_array($Email_Messages_Array)) {$Email_Messages_Array = array();}
?>
<div class="wrap">
<form method="post" action="admin.php?page=EWD-OTP-options&DisplayPage=Statuses&OTPAction=EWD_OTP_UpdateStatuses">
	<?php wp_nonce_field('EWD_OTP_Admin_Nonce', 'EWD_OTP_Admin_Nonce'); ?>
	<div id="icon-options-general" class="icon32"><br /></div>

	<div id="col-right">
		<table class="wp-list-table striped widefat tags sorttable status-list">
			<thead>
				<tr>
					<th><?php _e("Status", 'order-tracking') ?></th>
					<th><?php _e("&#37; Complete", 'order-tracking') ?></th>
					<th><?php _e("Email", 'order-tracking') ?></th>
					<th><?php _e("Internal Status", 'order-tracking') ?></th>
					<th></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><?php _e("Status", 'order-tracking') ?></th>
					<th><?php _e("&#37; Complete", 'order-tracking') ?></th>
					<th><?php _e("Email", 'order-tracking') ?></th>
					<th><?php _e("Internal Status", 'order-tracking') ?></th>
					<th></th>
				</tr>
			</tfoot>
					
			<?php 
			if (!is_array($Statuses_Array)) {$Statuses_Array = array();}
			foreach ($Statuses_Array as $key => $Status_Array_Item) { ?>
				<tr id="list-item-<?php echo $key; ?>" class="list-item edit-status-item">
					<td class="status"><input type='text' class='ewd-otp-edit-status-input' name='status[]' value='<?php echo stripslashes_deep($Status_Array_Item['Status']); ?>' /></td>
					<td class="status-completed"><input type='text' class='ewd-otp-edit-status-input ewd-otp-edit-status-percentage-input' name='status_percentages[]' value='<?php echo $Status_Array_Item['Percentage']; ?>' /></td>
					<td class="status-message">
						<select class="ewd-otp-statuses-select" name="status_messages[]" id="Status_Message"/>
							<option value='0' <?php echo ($Status_Array_Item['Message'] == 0 ? 'selected' : ''); ?>><?php _e("None", 'order-tracking'); ?></option>
							<?php foreach ($Email_Messages_Array as $Email_Message_Item) { ?>
								<option value='<?php echo $Email_Message_Item['Name']; ?>' <?php echo ($Status_Array_Item['Message'] == $Email_Message_Item['Name'] ? 'selected' : ''); ?>>
									<?php echo $Email_Message_Item['Name']; ?>
								</option>
							<?php } ?>
							<optgroup label='Ultimate WP Mail'>
								<?php $Emails = get_posts(array('post_type' => 'uwpm_mail_template', 'posts_per_page' => -1));
									foreach ($Emails as $Email) { ?>
										<option value='-<?php echo $Email->ID; ?>' <?php echo ($Status_Array_Item['Message'] == ($Email->ID * -1) ? 'selected' : ''); ?>>
											<?php echo $Email->post_title ?>
										</option>
								<?php } ?>
							</optgroup>
						</select>
					</td>
					<td class="status-internal">
						<select class="ewd-otp-statuses-select" name="status_internals[]" id="Status_Internal"/>
							<option value='No' <?php echo ($Status_Array_Item['Internal'] == 'No' ? 'selected' : ''); ?>>No</option>
							<option value='Yes' <?php echo ($Status_Array_Item['Internal'] == 'Yes' ? 'selected' : ''); ?>>Yes</option>
						</select>
					</td>
					<td class="status-delete"><a href="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_DeleteStatus&DisplayPage=Statuses&Status=<?php echo urlencode($Status_Array_Item['Status']); ?>"><?php _e("Delete", 'order-tracking') ?></a></td>
				</tr>	
			<?php } ?>
		
		</table>

	</div>	

	<div id="col-left">

		<h3>Add New Status</h3>
			<div class="form-field form-required">
				<label for="Status"><?php _e("Name of Status", 'order-tracking') ?></label>
				<input name="status[]" id="Status" type="text" size="60" />
			</div>
			<div class="form-field form-required">
				<label for="Status_Percentage"><?php _e("Percentage Complete", 'order-tracking') ?></label>
				<input name="status_percentages[]" id="Status_Percentage" type="text" size="60" />
				<p><?php _e("The percentage of the shipping process completed when this status is reached. Used in the shipping graphic.", 'order-tracking') ?></p>
			</div>
			<div class="form-field form-required">
				<label for="Status_Message"><?php _e("Email", 'order-tracking') ?></label>
				<select name="status_messages[]" id="Status_Message"/>
					<option value='0'><?php _e("None", 'order-tracking'); ?></option>
					<?php foreach ($Email_Messages_Array as $Email_Message_Item) { ?>
						<option value='<?php echo $Email_Message_Item['Name']; ?>'><?php echo $Email_Message_Item['Name']; ?></option>
					<?php } ?>
					<optgroup label='Ultimate WP Mail'>
						<?php $Emails = get_posts(array('post_type' => 'uwpm_mail_template', 'posts_per_page' => -1));
							foreach ($Emails as $Email) { ?>
								<option value='-<?php echo $Email->ID; ?>'><?php echo $Email->post_title ?></option>
						<?php } ?>
					</optgroup>
				</select>
				<p><?php _e("Which email should be sent when this status is selected? (Emailing frequency needs to be set to 'On Change'.", 'order-tracking') ?></p>
			</div>
			<div class="form-field form-required">
				<label for="Status_Internal"><?php _e("Internal Status?", 'order-tracking') ?></label>
				<select name="status_internals[]" id="Status_Internal"/>
					<option value='No'>No</option>
					<option value='Yes'>Yes</option>
				</select>
				<p><?php _e("Should this status only be seen by admins and sales reps?", 'order-tracking') ?></p>
			</div>
		
			<p class="submit"><input type="submit" name="Statuses_Submit" id="submit" class="button button-primary" value="Add Status"  /></p>

		</div> <!-- col-left -->

	</form>

</div>