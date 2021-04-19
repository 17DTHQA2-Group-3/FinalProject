<?php $Customer = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $EWD_OTP_customers WHERE Customer_ID ='%d'", intval( $_GET['Customer_ID'] ) ) ); ?>
<?php $Customer_Orders = $wpdb->get_results($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Customer_ID=%d", $Customer->Customer_ID)); ?>

<div id="col-right">
<div class="col-wrap">
<h3><?php _e("Customer Orders", 'order-tracking'); ?></h3>
<div>
<table class='wp-list-table striped widefat tags sorttable fields-list'>
	<thead>
		<tr>
			<th><?php _e("Order", 'order-tracking'); ?></th>
			<th><?php _e("Status", 'order-tracking'); ?></th>
			<th><?php _e("Location", 'order-tracking'); ?></th>
			<th><?php _e("Updated", 'order-tracking'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($Customer_Orders as $Customer_Order) { ?>
			<tr>
				<td><a href='admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_Order_Details&Selected=Order&Order_ID=<?php echo $Customer_Order->Order_ID; ?>'><?php echo $Customer_Order->Order_Name; ?></a></td> 
				<td><?php echo $Customer_Order->Order_Status; ?></td>
				<td><?php echo $Customer_Order->Order_Location; ?></td>
				<td><?php echo $Customer_Order->Order_Status_Updated; ?></td>
			</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<th><?php _e("Order", 'order-tracking'); ?></th>
			<th><?php _e("Status", 'order-tracking'); ?></th>
			<th><?php _e("Location", 'order-tracking'); ?></th>
			<th><?php _e("Updated", 'order-tracking'); ?></th>
		</tr>
	</tfoot>
</table>
</div>
</div>
</div>


<div id="col-left">
<div class="col-wrap">	
<div class="OptionTab ActiveTab" id="EditCustomer">
				
		<div class="form-wrap CustomerDetail">
				<a href="admin.php?page=EWD-OTP-options&DisplayPage=Customers" class="NoUnderline">&#171; <?php _e("Back", 'order-tracking') ?></a>
				<h3><?php echo __("Edit ", 'order-tracking') . $Customer->Customer_Name . __(" (Customer ID: ", 'order-tracking') . $Customer->Customer_ID . ")"; ?></h3>
				<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_EditCustomer&DisplayPage=Customers" class="validate" enctype="multipart/form-data">
				<input type="hidden" name="action" value="Edit_Customers" />
				<input type="hidden" name="Customer_ID" value="<?php echo $Customer->Customer_ID; ?>" />
				<?php wp_nonce_field('EWD_OTP_Admin_Nonce', 'EWD_OTP_Admin_Nonce'); ?>
				<?php wp_referer_field(); ?>
				<div class="form-field">
						<label for="Customer_Name"><?php _e("Name", 'UPCP') ?></label>
						<input name="Customer_Name" id="Customer_Name" type="text" value="<?php echo $Customer->Customer_Name;?>" size="60" />
						<p><?php _e("The name of the customer.", 'order-tracking') ?></p>
				</div>
				<div class="form-field">
						<label for="Customer_Email"><?php _e("Email", 'UPCP') ?></label>
						<input name="Customer_Email" id="Customer_Email" type="text" value="<?php echo $Customer->Customer_Email;?>" size="60" />
						<p><?php _e("The email address of the customer.", 'order-tracking') ?></p>
				</div>
				<div class="form-field">
						<label for="Sales_Rep_ID"><?php _e("Sales Rep ID", 'order-tracking') ?></label>
						<input name="Sales_Rep_ID" id="Sales_Rep_ID" type="text" value="<?php echo $Customer->Sales_Rep_ID;?>" size="60" />
						<p><?php _e("The sales rep's ID for this customer.", 'order-tracking') ?></p>
				</div>
				<div class="form-field">
					<label for="Customer_WP_ID"><?php _e("Customer WP Username:", 'order-tracking') ?></label>
					<select name="Customer_WP_ID" id="Customer_WP_ID">
					<option value=""></option>
					<?php 
						$Blog_ID = get_current_blog_id();
						$Users = get_users( 'blog_id=' . $Blog_ID ); 
						foreach ($Users as $User) {
							echo "<option value='" . $User->ID . "' ";
							if ($User->ID == $Customer->Customer_WP_ID) {echo "selected='selected'";}
							echo " >" . $User->display_name . "</option>";
						} 
					?>
					</select>
					<p><?php _e("What WordPress user, if any, is assigned to this customer?", 'order-tracking') ?></p>
				</div>
				<div class="form-field">
					<label for="Customer_FEUP_ID"><?php _e("Customer FEUP Username:", 'order-tracking') ?></label>
					<select name="Customer_FEUP_ID" id="Customer_FEUP_ID">
					<option value=""></option>
					<?php 
						if (function_exists("EWD_FEUP_Get_All_Users")) {$Users = EWD_FEUP_Get_All_Users();}
						else {$Users = array();}
						foreach ($Users as $User) {
							echo "<option value='" . $User->Get_User_ID() . "' ";
							if ($User->Get_User_ID() == $Customer->Customer_FEUP_ID) {echo "selected='selected'";}
							echo " >" . $User->Get_Username() . "</option>";
						} 
					?>
					</select>
					<p><?php _e("What FEUP user, if any, is assigned to this customer? For more information on FEUP users:", 'order-tracking') ?><a href="https://wordpress.org/plugins/front-end-only-users/">https://wordpress.org/plugins/front-end-only-users/</a></p>
				</div>
				<?php
						
						$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Customers'";
						$Fields = $wpdb->get_results($Sql);
						$MetaValues = $wpdb->get_results( $wpdb->prepare( "SELECT Field_ID, Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Customer_ID=%d", intval( $_GET['Customer_ID'] ) ) );
						unset($ReturnString);
                        $ReturnString = "";
						foreach ($Fields as $Field) {
								$Value = "";
								if (is_array($MetaValues)) {
									  foreach ($MetaValues as $Meta) {
												if ($Field->Field_ID == $Meta->Field_ID) {$Value = $Meta->Meta_Value;}
										}
								}
								$ReturnString .= "<tr><th><label for='" . $Field->Field_Slug . "'>" . $Field->Field_Name . ":</label></th>";
								if ($Field->Field_Type == "text" or $Field->Field_Type == "mediumint") {
					  			  $ReturnString .= "<td><input name='" . $Field->Field_Slug . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-text-input' type='text' value='" . $Value . "' /></td>";
								}
								elseif ($Field->Field_Type == "textarea") {
										$ReturnString .= "<td><textarea name='" . $Field->Field_Slug . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-textarea'>" . $Value . "</textarea></td>";
								} 
								elseif ($Field->Field_Type == "select") { 
										$Options = explode(",", $Field->Field_Values);
										$ReturnString .= "<td><select name='" . $Field->Field_Slug . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-select'>";
			 							foreach ($Options as $Option) {
												$ReturnString .= "<option value='" . $Option . "' ";
												if (trim($Option) == trim($Value)) {$ReturnString .= "selected='selected'";}
												$ReturnString .= ">" . $Option . "</option>";
										}
										$ReturnString .= "</select></td>";
								} 
								elseif ($Field->Field_Type == "radio") {
										$Counter = 0;
										$Options = explode(",", $Field->Field_Values);
										$ReturnString .= "<td>";
										foreach ($Options as $Option) {
												if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
												$ReturnString .= "<input type='radio' name='" . $Field->Field_Slug . "' value='" . $Option . "' class='ewd-otp-radio' ";
												if (trim($Option) == trim($Value)) {$ReturnString .= "checked";}
												$ReturnString .= ">" . $Option;
												$Counter++;
										} 
										$ReturnString .= "</td>";
								} 
								elseif ($Field->Field_Type == "checkbox") {
  									$Counter = 0;
										$Options = explode(",", $Field->Field_Values);
										$Values = explode(",", $Value);
										$ReturnString .= "<td>";
										foreach ($Options as $Option) {
												if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
												$ReturnString .= "<input type='checkbox' name='" . $Field->Field_Slug . "[]' value='" . $Option . "' class='ewd-otp-checkbox' ";
												if (in_array($Option, $Values)) {$ReturnString .= "checked";}
												$ReturnString .= ">" . $Option . "</br>";
												$Counter++;
										}
										$ReturnString .= "</td>";
								}
								elseif ($Field->Field_Type == "file") {
										$ReturnString .= "<td><input name='" . $Field->Field_Slug . "' class='ewd-otp-file-input' type='file' value='" . $Value . "' /><br />";
										$ReturnString .= "Current File: " . $Value . "</td>";
								}
								elseif ($Field->Field_Type == "picture") {
										$ReturnString .= "<td><input name='" . $Field->Field_Slug . "' class='ewd-otp-file-input' type='file' value='" . $Value . "' /><br />";
										$ReturnString .= "Current Image: <img class='ewd-otp-preview-image' src='" . site_url("/wp-content/uploads/order-tracking-uploads/") . $Value . "' /><br />";
								}
								elseif ($Field->Field_Type == "date") {
										$ReturnString .= "<td><input name='" . $Field->Field_Slug . "' class='ewd-otp-date-input' type='date' value='" . $Value . "' /></td>";
								} 
								elseif ($Field->Field_Type == "datetime") {
										$ReturnString .= "<td><input name='" . $Field->Field_Slug . "' class='ewd-otp-datetime-input' type='datetime-local' value='" . $Value . "' /></td>";
  							}
						}
						echo $ReturnString;
						?>

				<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'order-tracking') ?>" /></p>
				</form>
		</div>
			
</div>

<br class="clear" />
</div>
</div><!-- /col-left -->
