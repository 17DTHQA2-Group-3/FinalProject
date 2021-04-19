<?php 
$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
if (!is_array($Statuses_Array)) {$Statuses_Array = array();}
$Locations_Array = get_option("EWD_OTP_Locations_Array");
if (!is_array($Locations_Array)) {$Locations_Array = array();}
$Allow_Order_Payments = get_option("EWD_OTP_Allow_Order_Payments");
$Customers = $wpdb->get_results("SELECT * FROM $EWD_OTP_customers");
$Sales_Reps = $wpdb->get_results("SELECT * FROM $EWD_OTP_sales_reps");

$Order_Statuses = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $EWD_OTP_order_statuses_table_name WHERE Order_ID=%d", intval( $_GET['Order_ID'] ) ) );

if ($Sales_Rep_Only == "Yes") {
	$Current_User = wp_get_current_user();
	$Sql = "SELECT Sales_Rep_ID FROM $EWD_OTP_sales_reps WHERE Sales_Rep_WP_ID='" . $Current_User->ID . "'";
	$Sales_Rep_ID = $wpdb->get_var($Sql);
}
?>


<div id="ewd-otp-new-edit-order-screen">

	<div id="col-left">
		<div class="col-wrap">

			<div class="form-wrap" id="OrderDetail">
				<h2><?php _e("Add Order", 'order-tracking') ?></h2>
				<!-- Form to edit an order -->
				<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_AddOrder&DisplayPage=Orders" class="validate" enctype="multipart/form-data">
					<input type="hidden" name="action" value="Add_Order" />
					<?php wp_nonce_field('EWD_OTP_Admin_Nonce', 'EWD_OTP_Admin_Nonce'); ?>
					<?php wp_referer_field(); ?>

					<div class="ewd-otp-admin-edit-product-left">

						<div class="form-field form-required">
							<input name="Order_Name" id="Order_Name" type="text" placeholder="<?php _e('Order Name', 'order-tracking') ?>" />
						</div>

						<div class="ewd-otp-dashboard-new-widget-box ewd-widget-box-full ewd-otp-admin-closeable-widget-box ewd-otp-admin-edit-product-left-full-widget-box" id="ewd-otp-admin-edit-order-details-widget-box">
							<div class="ewd-otp-dashboard-new-widget-box-top"><?php _e('Order Details', 'order-tracking'); ?><span class="ewd-otp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-otp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
							<div class="ewd-otp-dashboard-new-widget-box-bottom">
								<table class="form-table">
									<tr>
										<th><label for="Order_Number"><?php _e("Order Number", 'order-tracking') ?></label></th>
										<td>
											<input type='text' name="Order_Number" id="Order_Number" size="60" />
										</td>
									</tr>
									<tr>
										<th><label for="Order_Email"><?php _e("Order Email", 'order-tracking') ?></label></th>
										<td>
											<input type='text' name="Order_Email" id="Order_Email" size="60" />
											<p><?php _e("The e-mail address to send order updates to, if you have selected that option.", 'order-tracking') ?></p>
										</td>
									</tr>
									<tr>
										<th><label for="Order_Status"><?php _e("Order Status", 'order-tracking') ?></label></th>
										<td>
											<select name="Order_Status" id="Order_Status" />
											<?php 
												foreach ($Statuses_Array as $Status_Array_Item) { ?>
													<option value='<?php echo $Status_Array_Item['Status']; ?>'><?php echo $Status_Array_Item['Status']; ?></option>
											<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<th><label for="Order_Location"><?php _e("Order Location", 'order-tracking') ?></label></label></th>
										<td>
											<select name="Order_Location" id="Order_Location" />
											<?php foreach ($Locations_Array as $Location_Array_Item) { ?>
												<option value="<?php echo $Location_Array_Item['Name']; ?>">
													<?php echo $Location_Array_Item['Name']; ?><?php if ($Location_Array_Item['Latitude'] != "") {echo " (" . $Location_Array_Item['Latitude'] . ", " . $Location_Array_Item['Longitude'] . ")";} ?>
												</option>
											<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<th><label for="Customer_ID"><?php _e("Customer", 'order-tracking') ?></label></th>
										<td>
											<select name="Customer_ID" id="Customer_ID" />
												<option value='0'>None</option>
												<?php foreach ($Customers as $Customer) { ?>
													<option value='<?php echo $Customer->Customer_ID; ?>' ><?php echo $Customer->Customer_Name; ?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<?php 
									if ($Sales_Rep_Only == "Yes") {
										echo "<input type='hidden' name='Sales_Rep_ID' value='" . $Sales_Rep_ID . "' />";
									}
									else {
									?>
										<tr>
											<th><label for="Sales_Rep_ID"><?php _e("Sales Rep", 'order-tracking') ?></label></th>
											<td>
												<select name="Sales_Rep_ID" id="Sales_Rep_ID" />
													<option value='0'>None</option>
													<?php foreach ($Sales_Reps as $Sales_Rep) { ?>
														<option value='<?php echo $Sales_Rep->Sales_Rep_ID; ?>' ><?php echo $Sales_Rep->Sales_Rep_First_Name . " " . $Sales_Rep->Sales_Rep_Last_Name; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
									<?php } ?>
									<tr>
										<th><label for="Order_Display"><?php _e("Show in Admin Table?", 'order-tracking') ?></label></th>
										<td>
											<input type='radio' name="Order_Display" value="Yes" checked>Yes<br/>
											<input type='radio' name="Order_Display" value="No">No<br/>
											<p><?php _e("Should this order appear in the orders table in the admin area?", 'order-tracking') ?></p>
										</td>
									</tr>
								</table>
							</div>
						</div>

						<div class="ewd-otp-dashboard-new-widget-box ewd-widget-box-full ewd-otp-admin-closeable-widget-box ewd-otp-admin-edit-product-left-full-widget-box<?php echo ( empty($Order->Order_Notes_Public) && empty($Order->Order_Notes_Private) && empty($Order->Order_Customer_Notes) ? ' ewd-otp-admin-widget-box-start-closed' : '' ); ?>" id="ewd-otp-admin-edit-order-notes-widget-box">
							<div class="ewd-otp-dashboard-new-widget-box-top"><?php _e('Order Notes', 'order-tracking'); ?><span class="ewd-otp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-otp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
							<div class="ewd-otp-dashboard-new-widget-box-bottom">
								<table class="form-table">
									<tr>
										<th><label for="Order_Notes_Public"><?php _e("Public Order Notes", 'order-tracking') ?></label></th>
										<td>
											<input type='text' name="Order_Notes_Public" id="Order_Notes_Public" />
											<p><?php _e("The notes visitors will see if you've included 'Notes' on the options page.", 'order-tracking') ?></p>
										</td>
									</tr>
									<tr>
										<th><label for="Order_Notes_Private"><?php _e("Private Order Notes", 'order-tracking') ?></label></th>
										<td>
											<input type='text' name="Order_Notes_Private" id="Order_Notes_Private" />
											<p><?php _e("Visible only to admins.", 'order-tracking') ?></p>
										</td>
									</tr>
									<tr>
										<th><label for="Order_Customer_Notes"><?php _e("Customer Order Notes", 'order-tracking') ?></label></th>
										<td>
											<input type='text' name="Order_Customer_Notes" id="Order_Customer_Notes" />
											<p><?php _e("The notes about an order posted by the customer from the front-end.", 'order-tracking') ?></p>
										</td>
									</tr>
								</table>
							</div>
						</div>

					</div> <!-- ewd-otp-admin-edit-product-left -->

					<div class="ewd-otp-admin-edit-product-right">

						<p class="submit ewd-otp-admin-edit-product-submit-p"><input type="submit" name="submit" id="submit" class="button-primary ewd-otp-admin-edit-product-save-button" value="<?php _e('Add Order', 'order-tracking') ?>"  /></p>

						<div class="ewd-otp-dashboard-new-widget-box ewd-widget-box-full ewd-otp-admin-closeable-widget-box" id="ewd-otp-admin-edit-order-need-help-widget-box">
							<div class="ewd-otp-dashboard-new-widget-box-top"><?php _e('Need Help?', 'order-tracking'); ?><span class="ewd-otp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-otp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
							<div class="ewd-otp-dashboard-new-widget-box-bottom">
								 <div class='ewd-otp-need-help-box'>
									<div class='ewd-otp-need-help-text'>Visit our Support Center for documentation and tutorials</div>
									<a class='ewd-otp-need-help-button' href='https://www.etoilewebdesign.com/support-center/?Plugin=OTP' target='_blank'>GET SUPPORT</a>
								</div>
							</div>
						</div>

						<div class="ewd-otp-dashboard-new-widget-box ewd-widget-box-full ewd-otp-admin-closeable-widget-box" id="ewd-otp-admin-edit-order-custom-fields-widget-box">
							<div class="ewd-otp-dashboard-new-widget-box-top"><?php _e('Custom Fields', 'order-tracking'); ?><span class="ewd-otp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-otp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
							<div class="ewd-otp-dashboard-new-widget-box-bottom">
								<table class="form-table">
									<?php
									$ReturnString = "";
									$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Orders'";
									$Fields = $wpdb->get_results($Sql);
									foreach ($Fields as $Field) {
										$ReturnString .= "<tr><th><label for='" . $Field->Field_Slug . "'>" . $Field->Field_Name . ":</label></th>";
										if ($Field->Field_Type == "text" or $Field->Field_Type == "mediumint") {
											$ReturnString .= "<td><input name='" . $Field->Field_Slug . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-text-input' type='text' /></td>";
										}
										elseif ($Field->Field_Type == "textarea") {
											$ReturnString .= "<td><textarea name='" . $Field->Field_Slug . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-textarea'></textarea></td>";
										} 
										elseif ($Field->Field_Type == "select") { 
											$Options = explode(",", $Field->Field_Values);
											$ReturnString .= "<td><select name='" . $Field->Field_Slug . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-select'>";
				 							foreach ($Options as $Option) {
												$ReturnString .= "<option value='" . $Option . "'>" . $Option . "</option>";
											}
											$ReturnString .= "</select></td>";
										} 
										elseif ($Field->Field_Type == "radio") {
											$Counter = 0;
											$Options = explode(",", $Field->Field_Values);
											$ReturnString .= "<td>";
											foreach ($Options as $Option) {
												if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
												$ReturnString .= "<input type='radio' name='" . $Field->Field_Slug . "' value='" . $Option . "' class='ewd-otp-radio' >" . $Option;
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
												$ReturnString .= "<input type='checkbox' name='" . $Field->Field_Slug . "[]' value='" . $Option . "' class='ewd-otp-checkbox' >" . $Option . "</br>";
												$Counter++;
											}
											$ReturnString .= "</td>";
										}
										elseif ($Field->Field_Type == "file") {
											$ReturnString .= "<td><input name='" . $Field->Field_Slug . "' class='ewd-otp-file-input' type='file' /><br /></td>";
										}
										elseif ($Field->Field_Type == "picture") {
											$ReturnString .= "<td><input name='" . $Field->Field_Slug . "' class='ewd-otp-file-input' type='file' /></td>";
										}
										elseif ($Field->Field_Type == "date") {
											$ReturnString .= "<td><input name='" . $Field->Field_Slug . "' class='ewd-otp-date-input' type='date' /></td>";
										} 
										elseif ($Field->Field_Type == "datetime") {
											$ReturnString .= "<td><input name='" . $Field->Field_Slug . "' class='ewd-otp-datetime-input' type='datetime-local' /></td>";
		  								}
									}
									echo $ReturnString;
									?>
								</table>
							</div>
						</div>

						<?php if ($Allow_Order_Payments == "Yes") { ?>
							<div class="ewd-otp-dashboard-new-widget-box ewd-widget-box-full ewd-otp-admin-closeable-widget-box" id="ewd-otp-admin-edit-order-payment-widget-box">
								<div class="ewd-otp-dashboard-new-widget-box-top"><?php _e('PayPal Payment', 'order-tracking'); ?><span class="ewd-otp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-otp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
								<div class="ewd-otp-dashboard-new-widget-box-bottom">
									<table class="form-table">
										<tr>
											<th><label for="Order_Payment_Price"><?php _e("Order Payment Price", 'order-tracking') ?></label></th>
											<td>
												<input type='text' name="Order_Payment_Price" id="Order_Payment_Price" />
											</td>
										</tr>
										<tr>
											<th><label for="Order_Payment_Completed"><?php _e("Payment Completed?", 'order-tracking') ?></label></th>
											<td>
												<input type='radio' name="Order_Payment_Completed" value="Yes" >Yes<br/>
												<input type='radio' name="Order_Payment_Completed" value="No" >No<br/>
												<p><?php _e("This field should automatically update when payment is made.", 'order-tracking') ?></p>
											</td>
										</tr>
										<tr>
											<th><label for="Order_PayPal_Receipt_Number"><?php _e("PayPal Transaction ID", 'order-tracking') ?></label></th>
											<td>
												<input type='text' name="Order_PayPal_Receipt_Number" id="Order_PayPal_Receipt_Number" />
												<p><?php _e("The transaction ID generated by PayPal for this order (leave blank until payment is made).", 'order-tracking') ?></p>
											</td>
										</tr>
									</table>
								</div>
							</div>
						<?php } ?>

					</div> <!-- edit-product-right -->
							
				</form>

			</div>

		<br class="clear" />
		</div>
	</div><!-- /col-left -->

</div> <!-- ewd-otp-new-edit-order-screen -->


