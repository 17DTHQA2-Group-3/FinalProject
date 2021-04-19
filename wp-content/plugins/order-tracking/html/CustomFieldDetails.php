<?php $Field = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_ID ='%d'", intval( $_GET['Field_ID'] ) ) ); ?>
		
<div class="OptionTab ActiveTab" id="EditCustomField">
		
		<div id="col-left">
		<div class="col-wrap">
		<div class="form-wrap TagDetail">
			<a href="admin.php?page=EWD-OTP-options&DisplayPage=CustomFields" class="NoUnderline">&#171; <?php _e("Back", 'order-tracking') ?></a>
			<h3>Edit <?php echo $Field->Field_Name;?></h3>
			<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_EditCustomField&DisplayPage=CustomFields" class="validate" enctype="multipart/form-data">
			<input type="hidden" name="action" value="Edit_Custom_Field" />
			<input type="hidden" name="Field_ID" value="<?php echo $Field->Field_ID; ?>" />
			<?php wp_nonce_field('EWD_OTP_Admin_Nonce', 'EWD_OTP_Admin_Nonce'); ?>
			<?php wp_referer_field(); ?>
			<div class="form-field form-required">
				<label for="Field_Name"><?php _e("Name of Field", 'order-tracking') ?></label>
				<input name="Field_Name" id="Field_Name" type="text" value="<?php echo $Field->Field_Name;?>" size="60" />
			</div>
			<div class="form-field form-required">
				<label for="Field_Slug"><?php _e("Slug", 'order-tracking') ?></label>
				<input name="Field_Slug" id="Field_Slug" type="text" value="<?php echo $Field->Field_Slug;?>" size="60" />
				<p><?php _e("An all-lowercase name that will be used to insert the field.", 'order-tracking') ?></p>
			</div>
			<div class="form-field">
				<label for="Field_Type"><?php _e("Type", 'order-tracking') ?></label>
				<select name="Field_Type" id="Field_Type">
					<option value='text' <?php if ($Field->Field_Type == "text") {echo "selected=selected";} ?>><?php _e("Short Text", 'order-tracking') ?></option>
					<option value='mediumint' <?php if ($Field->Field_Type == "mediumint") {echo "selected=selected";} ?>><?php _e("Integer", 'order-tracking') ?></option>
					<option value='select' <?php if ($Field->Field_Type == "select") {echo "selected=selected";} ?>><?php _e("Select Box", 'order-tracking') ?></option>
					<option value='radio' <?php if ($Field->Field_Type == "radio") {echo "selected=selected";} ?>><?php _e("Radio Button", 'order-tracking') ?></option>
					<option value='checkbox' <?php if ($Field->Field_Type == "checkbox") {echo "selected=selected";} ?>><?php _e("Checkbox", 'order-tracking') ?></option>
					<option value='textarea' <?php if ($Field->Field_Type == "textarea") {echo "selected=selected";} ?>><?php _e("Text Area", 'order-tracking') ?></option>
					<option value='file' <?php if ($Field->Field_Type == "file") {echo "selected=selected";} ?>><?php _e("File", 'order-tracking') ?></option>
					<option value='picture' <?php if ($Field->Field_Type == "picture") {echo "selected=selected";} ?>><?php _e("Picture", 'order-tracking') ?></option>
					<option value='date' <?php if ($Field->Field_Type == "date") {echo "selected=selected";} ?>><?php _e("Date", 'order-tracking') ?></option>
					<option value='datetime' <?php if ($Field->Field_Type == "datetime") {echo "selected=selected";} ?>><?php _e("Date/Time", 'order-tracking') ?></option>
				</select>
				<p><?php _e("The input method for the field and type of data that the field will hold.", 'order-tracking') ?></p>
			</div>
			<div class="form-field">
				<label for="Field_Description"><?php _e("Description", 'order-tracking') ?></label>
				<textarea name="Field_Description" id="Field_Description" rows="2" cols="40"><?php echo $Field->Field_Description;?></textarea>
				<p><?php _e("The description of the field, which you will see as the instruction for the field.", 'order-tracking') ?></p>
			</div>
			<div class="form-field">
				<label for="Field_Values"><?php _e("Input Values", 'order-tracking') ?></label>
				<input name="Field_Values" id="Field_Values" type="text" value="<?php echo $Field->Field_Values;?>"  size="60" />
				<p><?php _e("A comma-separated list of acceptable input values for this field. These values will be the options for select, checkbox, and radio inputs.", 'order-tracking') ?></p>
			</div>
			<div class="form-field">
				<label for="Field_Front_End_Display"><?php _e("Display in Customer Order Form?", 'order-tracking') ?></label>
				<input type="radio" name="Field_Front_End_Display" value='Yes' <?php if ($Field->Field_Front_End_Display == "Yes") {echo "checked=checked";} ?> /><?php _e("Yes", 'order-tracking') ?><br />
				<input type="radio" name="Field_Front_End_Display" value='No' <?php if ($Field->Field_Front_End_Display == "No") {echo "checked=checked";} ?> /><?php _e("No", 'order-tracking') ?>
				<p><?php _e("Use 'Input Values' above to restrict inputs.", 'order-tracking') ?><br/>
					<?php _e("Use caution for 'File' and 'Picture' type fields, as putting the customer-order shortcode on a public page with either of these field types can be a security risk.", 'order-tracking'); ?></p>
			</div>
			<div class="form-field">
				<label for="Field_Required"><?php _e("Required in Customer Order Form?", 'order-tracking') ?></label>
				<input type="radio" name="Field_Required" value='Yes' <?php if ($Field->Field_Required == "Yes") {echo "checked=checked";} ?> /><?php _e("Yes", 'order-tracking') ?><br />
				<input type="radio" name="Field_Required" value='No' <?php if ($Field->Field_Required == "No") {echo "checked=checked";} ?> /><?php _e("No", 'order-tracking') ?>
			</div>
			<div class="form-field">
				<label for="Field_Equivalent"><?php _e("WooCommerce Field Equivalent", 'order-tracking') ?></label>
				<select name="Field_Equivalent" id="Field_Equivalent">
					<option value='None' selected=selected><?php _e("None", 'order-tracking') ?></option>
					<option value='_order_total' <?php if ($Field->Field_Equivalent == "_order_total") {echo "selected=selected";} ?>><?php _e("Order Total", 'order-tracking') ?></option>
					<option value='_order_currency' <?php if ($Field->Field_Equivalent == "_order_currency") {echo "selected=selected";} ?>><?php _e("Order Currency", 'order-tracking') ?></option>
					<option value='_billing_first_name' <?php if ($Field->Field_Equivalent == "_billing_first_name") {echo "selected=selected";} ?>><?php _e("Billing First Name", 'order-tracking') ?></option>
					<option value='_billing_last_name' <?php if ($Field->Field_Equivalent == "_billing_last_name") {echo "selected=selected";} ?>><?php _e("Billing Last Name", 'order-tracking') ?></option>
					<option value='_billing_company' <?php if ($Field->Field_Equivalent == "_billing_company") {echo "selected=selected";} ?>><?php _e("Billing Company", 'order-tracking') ?></option>
					<option value='_billing_city' <?php if ($Field->Field_Equivalent == "_billing_city") {echo "selected=selected";} ?>><?php _e("Billing City", 'order-tracking') ?></option>
					<option value='_billing_country' <?php if ($Field->Field_Equivalent == "_billing_country") {echo "selected=selected";} ?>><?php _e("Billing Country", 'order-tracking') ?></option>
					<option value='_billing_email' <?php if ($Field->Field_Equivalent == "_billing_email") {echo "selected=selected";} ?>><?php _e("Billing Email", 'order-tracking') ?></option>
					<option value='_billing_phone' <?php if ($Field->Field_Equivalent == "_billing_phone") {echo "selected=selected";} ?>><?php _e("Billing Phone", 'order-tracking') ?></option>
					<option value='_shipping_first_name' <?php if ($Field->Field_Equivalent == "_shipping_first_name") {echo "selected=selected";} ?>><?php _e("Shipping First Name", 'order-tracking') ?></option>
					<option value='_shipping_last_name' <?php if ($Field->Field_Equivalent == "_shipping_last_name") {echo "selected=selected";} ?>><?php _e("Shipping Last Name", 'order-tracking') ?></option>
					<option value='_shipping_company' <?php if ($Field->Field_Equivalent == "_shipping_company") {echo "selected=selected";} ?>><?php _e("Shipping Company", 'order-tracking') ?></option>
					<option value='_shipping_city' <?php if ($Field->Field_Equivalent == "_shipping_city") {echo "selected=selected";} ?>><?php _e("Shipping City", 'order-tracking') ?></option>
					<option value='_shipping_country' <?php if ($Field->Field_Equivalent == "_shipping_country") {echo "selected=selected";} ?>><?php _e("Shipping Country", 'order-tracking') ?></option>
					<option value='_shipping_email' <?php if ($Field->Field_Equivalent == "_shipping_email") {echo "selected=selected";} ?>><?php _e("Shipping Email", 'order-tracking') ?></option>
					<option value='_shipping_phone' <?php if ($Field->Field_Equivalent == "_shipping_phone") {echo "selected=selected";} ?>><?php _e("Shipping Phone", 'order-tracking') ?></option>
				</select>
				<p><?php _e("If you are important orders from WooCommerce, what field is this equivalent to?", 'order-tracking') ?></p>
			</div>
			<div class="form-field">
				<label for="Field_Function"><?php _e("Field For?", 'order-tracking') ?></label>
				<select name="Field_Function" id="Field_Function">
					<option value='Orders' <?php if ($Field->Field_Function == "Orders") {echo "selected=selected";} ?> ><?php _e("Orders", 'order-tracking') ?></option>
					<option value='Customers' <?php if ($Field->Field_Function == "Customers") {echo "selected=selected";} ?> ><?php _e("Customers", 'order-tracking') ?></option>
					<option value='Sales_Reps' <?php if ($Field->Field_Function == "Sales_Reps") {echo "selected=selected";} ?> ><?php _e("Sales Reps", 'order-tracking') ?></option>
				</select>
				<p><?php _e("What should this field apply to: orders, customers or sales reps?", 'order-tracking') ?></p>
			</div>

			<div class="form-field">
				<label for="Field_Display"><?php _e("Display in Admin Table?", 'order-tracking') ?></label>
				<input type="radio" name="Field_Display" value='Yes' <?php if ($Field->Field_Display == "Yes") {echo "checked=checked";} ?> /><?php _e("Yes", 'order-tracking') ?><br />
				<input type="radio" name="Field_Display" value='No' <?php if ($Field->Field_Display == "No") {echo "checked=checked";} ?> /><?php _e("No", 'order-tracking') ?>
			</div>

			<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'order-tracking') ?>"  /></p>
			</form>
		</div>
		</div>
		</div>
</div>
