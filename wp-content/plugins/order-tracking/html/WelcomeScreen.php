<?php
	$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
	if (!is_array($Statuses_Array)) {$Statuses_Array = array();}

	$Order_Information = get_option("EWD_OTP_Order_Information");
	$Order_Email = get_option("EWD_OTP_Order_Email");
	$Form_Instructions = get_option("EWD_OTP_Form_Instructions");
	$Hide_Blank_Fields = get_option("EWD_OTP_Hide_Blank_Fields");
?>
<div class='ewd-otp-welcome-screen'>
	<div class='ewd-otp-welcome-screen-header'>
		<h1><?php _e('Welcome to Status and Order Tracking', 'order-tracking'); ?></h1>
		<p><?php _e('Thanks for choosing Status and Order Tracking! The following will help you get started with the setup by creating your first statuses and orders, as well as adding a tracking form to a page and configuring a few key options.', 'order-tracking'); ?></p>
	</div>

	<div class='ewd-otp-welcome-screen-box ewd-otp-welcome-screen-statuses ewd-otp-welcome-screen-open' data-screen='statuses'>
		<h2><?php _e('1. Statuses', 'order-tracking'); ?></h2>
		<div class='ewd-otp-welcome-screen-box-content'>
			<p><?php _e('Create statuses or edit the default statuses so that they\'re meaningful for your visitors.', 'order-tracking'); ?></p>
			<div class='ewd-otp-welcome-screen-statuses-table'>
				<table class="wp-list-table striped widefat tags sorttable status-list">
					<thead>
						<tr>
							<th><?php _e("Status", 'order-tracking') ?></th>
							<th><?php _e("&#37; Complete", 'order-tracking') ?></th>
							<th></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th><?php _e("Status", 'order-tracking') ?></th>
							<th><?php _e("&#37; Complete", 'order-tracking') ?></th>
							<th></th>
						</tr>
					</tfoot>
					
					<tbody>
						<?php 
						if (!is_array($Statuses_Array)) {$Statuses_Array = array();}
						foreach ($Statuses_Array as $key => $Status_Array_Item) { ?>
							<tr class="list-item edit-status-item">
								<td class="status"><input type='text' class='ewd-otp-welcome-edit-status-input' name='status[]' value='<?php echo stripslashes_deep($Status_Array_Item['Status']); ?>' /></td>
								<td class="status-completed"><input type='text' class='ewd-otp-welcome-edit-status-input ewd-otp-edit-status-percentage-input' name='status_percentages[]' value='<?php echo $Status_Array_Item['Percentage']; ?>' /></td>
								<td class="status-delete"><?php _e("Delete", 'order-tracking') ?></td>
							</tr>	
						<?php } ?>
					</tbody>
		
				</table>
			</div>
			<div class='ewd-otp-welcome-screen-create-status'>
				<div class='ewd-otp-welcome-screen-add-status-name ewd-otp-welcome-screen-box-content-divs-top-margin'><label><?php _e('Status Name:', 'order-tracking'); ?></label><input type='text' /></div>
				<div class='ewd-otp-welcome-screen-add-status-percentage ewd-otp-welcome-screen-box-content-divs'><label><?php _e('Percentage Complete:', 'order-tracking'); ?></label><input type='text' /></div>
				<div class='ewd-otp-welcome-screen-add-status-button'><?php _e('Add Status', 'order-tracking'); ?></div>
			</div>
			<div class="ewd-otp-welcome-clear"></div>
			<div class='ewd-otp-welcome-screen-next-button' data-nextaction='tracking-page'><?php _e('Next', 'order-tracking'); ?></div>
			<div class='ewd-otp-clear'></div>
		</div>
	</div>
<?php  if (!isset($_GET['exclude'])) { ?>
	<div class='ewd-otp-welcome-screen-box ewd-otp-welcome-screen-tracking-page' data-screen='tracking-page'>
		<h2><?php _e('2. Tracking Page', 'order-tracking'); ?></h2>
		<div class='ewd-otp-welcome-screen-box-content'>
			<p><?php _e('You can create a dedicated tracking page below, or skip this step and add your tracking form to a page you\'ve already created manually.', 'order-tracking'); ?></p>
			<div class='ewd-otp-welcome-screen-tracking-page'>
				<div class='ewd-otp-welcome-screen-add-tracking-page-name ewd-otp-welcome-screen-box-content-divs'><label><?php _e('Page Title:', 'order-tracking'); ?></label><input type='text' value='Order Tracking' /></div>
				<div class='ewd-otp-welcome-screen-add-tracking-page-button'><?php _e('Create Page', 'order-tracking'); ?></div>
			</div>
			<div class="ewd-otp-welcome-clear"></div>
			<div class='ewd-otp-welcome-screen-next-button' data-nextaction='options'><?php _e('Next', 'order-tracking'); ?></div>
			<div class='ewd-otp-welcome-screen-previous-button' data-previousaction='statuses'><?php _e('Previous', 'order-tracking'); ?></div>
			<div class='ewd-otp-clear'></div>
		</div>
	</div>

	<div class='ewd-otp-welcome-screen-box ewd-otp-welcome-screen-options' data-screen='options'>
		<h2><?php _e('3. Set Key Options', 'order-tracking'); ?></h2>
		<div class='ewd-otp-welcome-screen-box-content'>
			<p><?php _e('Options can always be changed later, but here are a few that a lot of users want to set for themselves.', 'order-tracking'); ?></p>
			<table class="form-table">
				<tr>
					<th><?php _e('Order Information Displayed', 'order-tracking'); ?></th>
					<td>
						<div class='ewd-otp-welcome-screen-option'>
							<fieldset>
								<legend class="screen-reader-text"><span>Order Information Displayed</span></legend>
								<label title='Order Number' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Number' <?php if(in_array("Order_Number", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Order Number</span></label><br />
								<label title='Name' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Name' <?php if(in_array("Order_Name", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Name</span></label><br />
								<label title='Status' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Status' <?php if(in_array("Order_Status", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Status</span></label><br />
								<label title='Location' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Location' <?php if(in_array("Order_Location", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Location</span></label><br />
								<label title='Update Date' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Updated' <?php if(in_array("Order_Updated", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Updated Date</span></label><br />
								<label title='Notes' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Notes' <?php if(in_array("Order_Notes", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Notes</span></label><br />
								<label title='Customer_Notes' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Customer_Notes' <?php if(in_array("Customer_Notes", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Customer Notes</span></label><br />
								<label title='Graphic' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Graphic' <?php if(in_array("Order_Graphic", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Status Graphic</span></label><br />
								<p>Select what information should be displayed for each order.</p>
							</fieldset>
						</div>
					</td>
				</tr>
				<tr>
					<th><?php _e('Order Email Frequency', 'order-tracking'); ?></th>
					<td>
						<div class='ewd-otp-welcome-screen-option'>
							<fieldset>
								<legend class="screen-reader-text"><span>Order Email Frequency</span></legend>
								<label title='On Change' class='ewd-otp-admin-input-container'><input type='radio' name='order_email' value='Change' <?php if($Order_Email == "Change") {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-radio-button'></span> <span>On Change</span></label><br />
								<label title='On Creation' class='ewd-otp-admin-input-container'><input type='radio' name='order_email' value='Creation' <?php if($Order_Email == "Creation") {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-radio-button'></span> <span>On Creation</span></label><br />
								<label title='Never' class='ewd-otp-admin-input-container'><input type='radio' name='order_email' value='Never' <?php if($Order_Email == "Never") {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-radio-button'></span> <span>Never</span></label><br />
								<p>How often should emails be sent to customers about the status of their orders?</p>
							</fieldset>
						</div>
					</td>
				</tr>
				<tr>
					<th><?php _e('Order Form Instructions', 'order-tracking'); ?></th>
					<td>
						<div class='ewd-otp-welcome-screen-option'>
							<fieldset>
								<legend class="screen-reader-text"><span>Order Form Instructions</span></legend>
								<label title='Form Instructions'></label><textarea class='ewd-otp-textarea' name='form_instructions'> <?php echo $Form_Instructions; ?></textarea><br />
								<p>The instructions that will display above the order form.</p>
							</fieldset>
						</div>
					</td>
				</tr>
				<tr>
					<th><?php _e('Hide Blank Fields', 'order-tracking'); ?></th>
					<td>
						<div class='ewd-otp-welcome-screen-option'>
							<fieldset>
								<legend class="screen-reader-text"><span>Hide Blank Fields</span></legend>
								<div class="ewd-otp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='hide_blank_fields' value='Yes' <?php if($Hide_Blank_Fields == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='hide_blank_fields' value='No' <?php if($Hide_Blank_Fields == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-otp-admin-switch">
									<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="hide_blank_fields" <?php if($Hide_Blank_Fields == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-otp-admin-switch-slider round"></span>
								</label>		
								<p>Should fields which don't have a value (ex. customer name, custom fields) be hidden if they're empty?</p>
							</fieldset>
						</div>
					</td>
				</tr>
			</table>

			<div class='ewd-otp-welcome-screen-save-options-button'><?php _e('Save Options', 'order-tracking'); ?></div>
			<div class="ewd-otp-welcome-clear"></div>
			<div class='ewd-otp-welcome-screen-previous-button' data-previousaction='tracking-page'><?php _e('Previous', 'order-tracking'); ?></div>
			<div class='ewd-otp-welcome-screen-next-button' data-nextaction='orders'><?php _e('Next', 'order-tracking'); ?></div>
			
			<div class='ewd-otp-clear'></div>
		</div>
	</div>
<?php } ?>
	<div class='ewd-otp-welcome-screen-box ewd-otp-welcome-screen-orders' data-screen='orders'>
		<h2><?php echo (isset($_GET['exclude']) ? '2.' : '4.') . __('Create an Order', 'order-tracking'); ?></h2>
		<div class='ewd-otp-welcome-screen-box-content'>
			<p><?php _e('Create your first orders. Don\'t worry, you can always add more later.', 'order-tracking'); ?></p>
			<div class='ewd-otp-welcome-screen-created-orders'>
				<div class='ewd-otp-welcome-screen-add-order-name ewd-otp-welcome-screen-box-content-divs'><label><?php _e('Order Name:', 'order-tracking'); ?></label><input type='text' /></div>
				<div class='ewd-otp-welcome-screen-add-order-number ewd-otp-welcome-screen-box-content-divs'><label><?php _e('Order Number:', 'order-tracking'); ?></label><input type='text' /></div>
				<div class='ewd-otp-welcome-screen-add-order-email ewd-otp-welcome-screen-box-content-divs'><label><?php _e('Order Email:', 'order-tracking'); ?></label><input type='text' /></div>
				<div class='ewd-otp-welcome-screen-add-order-status ewd-otp-welcome-screen-box-content-divs'><label><?php _e('Order Status:', 'order-tracking'); ?></label>
					<select>
						<?php foreach ($Statuses_Array as $Status_Array_Item) { ?><option value='<?php echo $Status_Array_Item['Status']; ?>'><?php echo $Status_Array_Item['Status']; ?></option><?php }?>
					</select>
				</div>
				<div class='ewd-otp-welcome-screen-add-order-button'><?php _e('Add Order', 'order-tracking'); ?></div>
				<div class="ewd-otp-welcome-clear"></div>
				<div class="ewd-otp-welcome-screen-show-created-orders">
					<h3><?php _e('Created Orders:', 'order-tracking'); ?></h3>
					<div class="ewd-otp-welcome-screen-show-created-order-name"><?php _e('Name', 'order-tracking'); ?></div>
					<div class="ewd-otp-welcome-screen-show-created-order-number"><?php _e('Order Number', 'order-tracking'); ?></div>
					<div class="ewd-otp-welcome-screen-show-created-order-status"><?php _e('Status', 'order-tracking'); ?></div>
				</div>
			</div>
			<div class="ewd-otp-welcome-clear"></div>
			<div class='ewd-otp-welcome-screen-previous-button' data-previousaction='options'><?php _e('Previous', 'order-tracking'); ?></div>
			<div class='ewd-otp-welcome-screen-finish-button'><a href='admin.php?page=EWD-OTP-options'><?php _e('Finish', 'order-tracking'); ?></a></div>
			<div class='ewd-otp-clear'></div>
		</div>
	</div>

	<div class='ewd-otp-welcome-screen-skip-container'>
		<a href='admin.php?page=EWD-OTP-options'><div class='ewd-otp-welcome-screen-skip-button'><?php _e('Skip Setup', 'order-tracking'); ?></div></a>
	</div>
</div>