<?php $SalesRep = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $EWD_OTP_sales_reps WHERE Sales_Rep_ID ='%d'", intval( $_GET['Sales_Rep_ID'] ) ) ); ?>
<?php $SalesRep_Orders = $wpdb->get_results($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Sales_Rep_ID=%d", $SalesRep->Sales_Rep_ID)); ?>

<div id="col-right">
<div class="col-wrap">
<h3><?php _e("Sales Rep Orders", 'order-tracking'); ?></h3>
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
		<?php foreach ($SalesRep_Orders as $SalesRep_Order) { ?>
			<tr>
				<td><a href='admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_Order_Details&Selected=Order&Order_ID=<?php echo $SalesRep_Order->Order_ID; ?>'><?php echo $SalesRep_Order->Order_Name; ?></a></td> 
				<td><?php echo $SalesRep_Order->Order_Status; ?></td>
				<td><?php echo $SalesRep_Order->Order_Location; ?></td>
				<td><?php echo $SalesRep_Order->Order_Status_Updated; ?></td>
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
<div class="OptionTab ActiveTab" id="EditSalesRep">
				
		<div class="form-wrap SalesRepDetail">
				<a href="admin.php?page=EWD-OTP-options&DisplayPage=SalesReps" class="NoUnderline">&#171; <?php _e("Back", 'order-tracking') ?></a>
				<h3><?php echo __("Edit ", 'order-tracking') . $SalesRep->Sales_Rep_First_Name . " " . $SalesRep->Sales_Rep_Last_Name . __(" (Sales Rep ID: ", 'order-tracking') . $SalesRep->Sales_Rep_ID . ")"; ?></h3>
				<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_EditSalesRep&DisplayPage=SalesReps" class="validate" enctype="multipart/form-data">
				<input type="hidden" name="action" value="Edit_Sales_Rep" />
				<input type="hidden" name="Sales_Rep_ID" value="<?php echo $SalesRep->Sales_Rep_ID; ?>" />
				<?php wp_nonce_field('EWD_OTP_Admin_Nonce', 'EWD_OTP_Admin_Nonce'); ?>
				<?php wp_referer_field(); ?>
				<div class="form-field">
						<label for="Sales_Rep_First_Name"><?php _e("First Name", 'UPCP') ?></label>
						<input name="Sales_Rep_First_Name" id="Sales_Rep_First_Name" type="text" value="<?php echo $SalesRep->Sales_Rep_First_Name;?>" size="60" />
						<p><?php _e("The first name of the sales rep.", 'order-tracking') ?></p>
				</div>
				<div class="form-field">
						<label for="Sales_Rep_Last_Name"><?php _e("Last Name", 'order-tracking') ?></label>
						<input name="Sales_Rep_Last_Name" id="Sales_Rep_Last_Name" type="text" value="<?php echo $SalesRep->Sales_Rep_Last_Name;?>" size="60" />
						<p><?php _e("The last name of the sales rep.", 'order-tracking') ?></p>
				</div>
				<div class="form-field form-required">
					<label for="Sales_Rep_Email"><?php _e("Sales Rep Email", 'order-tracking') ?></label>
					<input name="Sales_Rep_Email" id="Sales_Rep_Email" type="text" value="<?php echo $SalesRep->Sales_Rep_Email;?>" size="60" />
					<p><?php _e("The email address of the sales rep.", 'order-tracking') ?></p>
				</div>
				<div class="form-field">
					<label for="Sales_Rep_WP_ID"><?php _e("Sales Rep WP Username:", 'order-tracking') ?></label>
					<select name="Sales_Rep_WP_ID" id="Sales_Rep_WP_ID">
					<option value=""></option>
					<?php 
						$Blog_ID = get_current_blog_id();
						$Users = get_users( 'blog_id=' . $Blog_ID ); 
						foreach ($Users as $User) {
							echo "<option value='" . $User->ID . "' ";
							if ($User->ID == $SalesRep->Sales_Rep_WP_ID) {echo "selected='selected'";}
							echo " >" . $User->display_name . "</option>";
						} 
					?>
					</select>
					<p><?php _e("What WordPress user should be able to update the orders assigned to this Sales Rep?", 'order-tracking') ?></p>
				</div>

				<?php
						
						$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Sales_Reps'";
						$Fields = $wpdb->get_results($Sql);
						$MetaValues = $wpdb->get_results( $wpdb->prepare( "SELECT Field_ID, Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Sales_Rep_ID=%d", intval( $_GET['Sales_Rep_ID'] ) ) );
						unset($ReturnString);
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
												$ReturnString .= "<input type='checkbox' name='" . $Field->Field_Slug. "[]' value='" . $Option . "' class='ewd-otp-checkbox' ";
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