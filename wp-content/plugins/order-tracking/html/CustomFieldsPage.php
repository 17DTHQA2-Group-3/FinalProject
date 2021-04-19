<?php if ($EWD_OTP_Full_Version == "Yes") { ?>
<div id="col-right">
<div class="col-wrap">

<!-- Display a list of the products which have already been created -->
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>

<?php
    $Number_Of_Pages = "";
    
			if (isset($_GET['Page'])) {$Page = intval( $_GET['Page'] );}
			else {$Page = 1;}

			if ( isset( $_GET['OrderBy'] ) and in_array( $_GET['OrderBy'], array( 'Field_Name', 'Field_Slug', 'Field_Type', 'Field_Description' ) ) ) { $OrderBy = $_GET['OrderBy']; }
			else { $OrderBy = 'Field_Order'; }

			$Order = ( isset( $_GET['Order'] ) and $_GET['Order'] == 'DESC' ) ? 'DESC' : 'ASC';
			
			$Sql = "SELECT * FROM $EWD_OTP_fields_table_name ";
				if (isset($_GET['OrderBy'])) {$Sql .= "ORDER BY " . $OrderBy . " " . $Order . " ";}
				else {$Sql .= "ORDER BY Field_Order ";}
				$Sql .= "LIMIT " . ($Page - 1)*20 . ",20";
				$myrows = $wpdb->get_results($Sql);
				$TotalFields = $wpdb->get_results("SELECT Field_ID FROM $EWD_OTP_fields_table_name");
				$num_rows = $wpdb->num_rows; 
				$Number_of_Pages = ceil($num_rows/20);
				echo $Number_Of_Pages;
				$Current_Page_With_Order_By = "admin.php?page=EWD-OTP-options&DisplayPage=CustomFields";
				if (isset($_GET['OrderBy'])) {$Current_Page_With_Order_By .= "&OrderBy=" . $OrderBy . "&Order=" . $Order;}?>

<form action="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_MassDeleteCustomFields&DisplayPage=CustomFields" method="post">    
<div class="tablenav top">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'order-tracking') ?></option>
						<option value='delete'><?php _e("Delete", 'order-tracking') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'order-tracking') ?>"  />
		</div>
		<div class='tablenav-pages <?php if ($Number_of_Pages == 1) {echo "one-page";} ?>'>
				<span class="displaying-num"><?php echo $wpdb->num_rows; ?> <?php _e("items", 'order-tracking') ?></span>
				<span class='pagination-links'>
						<a class='first-page <?php if ($Page == 1) {echo "disabled";} ?>' title='Go to the first page' href='<?php echo esc_attr( $Current_Page_With_Order_By ); ?>&Page=1'>&laquo;</a>
						<a class='prev-page <?php if ($Page <= 1) {echo "disabled";} ?>' title='Go to the previous page' href='<?php echo esc_attr( $Current_Page_With_Order_By ); ?>&Page=<?php echo $Page-1;?>'>&lsaquo;</a>
						<span class="paging-input"><?php echo $Page; ?> <?php _e("of", 'order-tracking') ?> <span class='total-pages'><?php echo $Number_of_Pages; ?></span></span>
						<a class='next-page <?php if ($Page >= $Number_of_Pages) {echo "disabled";} ?>' title='Go to the next page' href='<?php echo esc_attr( $Current_Page_With_Order_By ); ?>&Page=<?php echo $Page+1;?>'>&rsaquo;</a>
						<a class='last-page <?php if ($Page == $Number_of_Pages) {echo "disabled";} ?>' title='Go to the last page' href='<?php echo esc_attr( $Current_Page_With_Order_By ) . "&Page=" . $Number_of_Pages; ?>'>&raquo;</a>
				</span>
		</div>
</div>

<table class="wp-list-table striped widefat fixed tags sorttable custom-fields-list" cellspacing="0">
		<thead>
				<tr>
						<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
								<input type="checkbox" /></th><th scope='col' id='field-name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Field_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Name&Order=ASC'>";} ?>
											  <span><?php _e("Field Name", 'order-tracking') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Field_Slug" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Slug&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Slug&Order=ASC'>";} ?>
											  <span><?php _e("Field Slug", 'order-tracking') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='type' class='manage-column column-type sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Field_Type" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Type&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Type&Order=ASC'>";} ?>
											  <span><?php _e("Type", 'order-tracking') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Field_Description" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Description&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Description&Order=ASC'>";} ?>
											  <span><?php _e("Description", 'order-tracking') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
				</tr>
		</thead>

		<tfoot>
				<tr>
						<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
								<input type="checkbox" /></th><th scope='col' id='field-name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Field_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Name&Order=ASC'>";} ?>
											  <span><?php _e("Field Name", 'order-tracking') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Field_Slug" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Slug&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Slug&Order=ASC'>";} ?>
											  <span><?php _e("Field Slug", 'order-tracking') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='type' class='manage-column column-type sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Field_Type" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Type&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Type&Order=ASC'>";} ?>
											  <span><?php _e("Type", 'order-tracking') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Field_Description" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Description&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=CustomFields&OrderBy=Field_Description&Order=ASC'>";} ?>
											  <span><?php _e("Description", 'order-tracking') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
				</tr>
		</tfoot>

	<tbody id="the-list" class='list:tag'>
		
		 <?php
				if ($myrows) { 
	  			  foreach ($myrows as $Field) {
								echo "<tr id='custom-field-item-" . $Field->Field_ID ."' class='custom-field-list-item'>";
								echo "<th scope='row' class='check-column'>";
								echo "<input type='checkbox' name='Fields_Bulk[]' value='" . $Field->Field_ID ."' />";
								echo "</th>";
								echo "<td class='name column-name'>";
								echo "<strong>";
								echo "<a class='row-title' href='admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_FieldDetails&Selected=CustomField&Field_ID=" . $Field->Field_ID ."' title='Edit " . $Field->Field_Name . "'>" . $Field->Field_Name . "</a></strong>";
								echo "<br />";
								echo "<div class='row-actions'>";
								echo "<span class='delete'>";
								echo "<a class='delete-tag' href='admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_DeleteCustomField&DisplayPage=CustomFields&Field_ID=" . $Field->Field_ID ."'>" . __("Delete", 'order-tracking') . "</a>";
		 						echo "</span>";
								echo "</div>";
								echo "<div class='hidden' id='inline_" . $Field->Field_ID ."'>";
								echo "<div class='name'>" . $Field->Field_Name . "</div>";
								echo "</div>";
								echo "</td>";
								echo "<td class='description column-slug'>" . $Field->Field_Slug . "</td>";
								echo "<td class='description column-type'>" . $Field->Field_Type . "</td>";
								echo "<td class='description column-description'>" . substr($Field->Field_Description, 0, 60);
								if (strlen($Field->Field_Description) > 60) {echo "...";}
								echo "</td>";
								echo "</tr>";
						}
				}
		?>

	</tbody>
</table>

<div class="tablenav bottom">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'order-tracking') ?></option>
						<option value='delete'><?php _e("Delete", 'order-tracking') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'order-tracking') ?>"  />
		</div>
		<div class='tablenav-pages <?php if ($Number_of_Pages == 1) {echo "one-page";} ?>'>
				<span class="displaying-num"><?php echo $wpdb->num_rows; ?> <?php _e("items", 'order-tracking') ?></span>
				<span class='pagination-links'>
						<a class='first-page <?php if ($Page == 1) {echo "disabled";} ?>' title='Go to the first page' href='<?php echo esc_attr( $Current_Page_With_Order_By ); ?>&Page=1'>&laquo;</a>
						<a class='prev-page <?php if ($Page <= 1) {echo "disabled";} ?>' title='Go to the previous page' href='<?php echo esc_attr( $Current_Page_With_Order_By ); ?>&Page=<?php echo $Page-1;?>'>&lsaquo;</a>
						<span class="paging-input"><?php echo $Page; ?> <?php _e("of", 'order-tracking') ?> <span class='total-pages'><?php echo $Number_of_Pages; ?></span></span>
						<a class='next-page <?php if ($Page >= $Number_of_Pages) {echo "disabled";} ?>' title='Go to the next page' href='<?php echo esc_attr( $Current_Page_With_Order_By ); ?>&Page=<?php echo $Page+1;?>'>&rsaquo;</a>
						<a class='last-page <?php if ($Page == $Number_of_Pages) {echo "disabled";} ?>' title='Go to the last page' href='<?php echo esc_attr( $Current_Page_With_Order_By ) . "&Page=" . $Number_of_Pages; ?>'>&raquo;</a>
				</span>
		</div>
		<br class="clear" />
</div>
</form>

<br class="clear" />
</div>
</div> <!-- /col-right -->


<!-- Form to upload a list of new products from a spreadsheet -->
<div id="col-left">
<div class="col-wrap">

<div class="form-wrap">
<h2><?php _e("Add New Field", 'order-tracking') ?></h2>
<!-- Form to create a new field -->
<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_AddCustomField&DisplayPage=CustomFields" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Add_Custom_Field" />
<?php wp_nonce_field('EWD_OTP_Admin_Nonce', 'EWD_OTP_Admin_Nonce'); ?>
<?php wp_referer_field(); ?>
<div class="form-field form-required">
	<label for="Field_Name"><?php _e("Name of Field", 'order-tracking') ?></label>
	<input name="Field_Name" id="Field_Name" type="text" value="" size="60" />
</div>
<div class="form-field form-required">
	<label for="Field_Slug"><?php _e("Slug", 'order-tracking') ?></label>
	<input name="Field_Slug" id="Field_Slug" type="text" value="" size="60" />
	<p><?php _e("An all-lowercase name that will be used to insert the field.", 'order-tracking') ?></p>
</div>
<div class="form-field">
	<label for="Field_Type"><?php _e("Type", 'order-tracking') ?></label>
	<select name="Field_Type" id="Field_Type">
			<option value='text'><?php _e("Short Text", 'order-tracking') ?></option>
			<option value='mediumint'><?php _e("Integer", 'order-tracking') ?></option>
			<option value='select'><?php _e("Select Box", 'order-tracking') ?></option>
			<option value='radio'><?php _e("Radio Button", 'order-tracking') ?></option>
			<option value='checkbox'><?php _e("Checkbox", 'order-tracking') ?></option>
			<option value='textarea'><?php _e("Text Area", 'order-tracking') ?></option>
			<option value='file'><?php _e("File", 'order-tracking') ?></option>
			<option value='picture'><?php _e("Picture", 'order-tracking') ?></option>
			<option value='date'><?php _e("Date", 'order-tracking') ?></option>
			<option value='datetime'><?php _e("Date/Time", 'order-tracking') ?></option>
	</select>
	<p><?php _e("The input method for the field and type of data that the field will hold.", 'order-tracking') ?></p>
</div>
<div class="form-field">
	<label for="Field_Description"><?php _e("Description", 'order-tracking') ?></label>
	<textarea name="Field_Description" id="Field_Description" rows="2" cols="40"></textarea>
	<p><?php _e("The description of the field, which you will see as the instruction for the field.", 'order-tracking') ?></p>
</div>
<div class="form-field">
	<label for="Field_Values"><?php _e("Input Values", 'order-tracking') ?></label>
	<input name="Field_Values" id="Field_Values" type="text" size="60" />
	<p><?php _e("A comma-separated list of acceptable input values for this field. These values will be the options for select, checkbox, and radio inputs.", 'order-tracking') ?></p>
</div>
<div class="form-field">
	<label for="Field_Front_End_Display"><?php _e("Display in Customer Order Form?", 'order-tracking') ?></label>
	<input type="radio" name="Field_Front_End_Display" value='Yes' /><?php _e("Yes", 'order-tracking') ?><br />
	<input type="radio" name="Field_Front_End_Display" value='No' checked=checked /><?php _e("No", 'order-tracking') ?>
	<p><?php _e("Use 'Input Values' above to restrict inputs.", 'order-tracking') ?><br/>
		<?php _e("Use caution for 'File' and 'Picture' type fields, as putting the customer-order shortcode on a public page with either of these field types can be a security risk.", 'order-tracking'); ?></p>
</div>
<div class="form-field">
	<label for="Field_Required"><?php _e("Required in Customer Order Form?", 'order-tracking') ?></label>
	<input type="radio" name="Field_Required" value='Yes' /><?php _e("Yes", 'order-tracking') ?><br />
	<input type="radio" name="Field_Required" value='No' checked=checked /><?php _e("No", 'order-tracking') ?>
</div>
<div class="form-field">
	<label for="Field_Equivalent"><?php _e("WooCommerce Field Equivalent", 'order-tracking') ?></label>
	<select name="Field_Equivalent" id="Field_Equivalent">
		<option value='None' selected=selected><?php _e("None", 'order-tracking') ?></option>
		<option value='_order_total'><?php _e("Order Total", 'order-tracking') ?></option>
		<option value='_order_currency'><?php _e("Order Currency", 'order-tracking') ?></option>
		<option value='_billing_first_name'><?php _e("Billing First Name", 'order-tracking') ?></option>
		<option value='_billing_last_name'><?php _e("Billing Last Name", 'order-tracking') ?></option>
		<option value='_billing_company'><?php _e("Billing Company", 'order-tracking') ?></option>
		<option value='_billing_city'><?php _e("Billing City", 'order-tracking') ?></option>
		<option value='_billing_country'><?php _e("Billing Country", 'order-tracking') ?></option>
		<option value='_billing_email'><?php _e("Billing Email", 'order-tracking') ?></option>
		<option value='_billing_phone'><?php _e("Billing Phone", 'order-tracking') ?></option>
		<option value='_shipping_first_name'><?php _e("Shipping First Name", 'order-tracking') ?></option>
		<option value='_shipping_last_name'><?php _e("Shipping Last Name", 'order-tracking') ?></option>
		<option value='_shipping_company'><?php _e("Shipping Company", 'order-tracking') ?></option>
		<option value='_shipping_city'><?php _e("Shipping City", 'order-tracking') ?></option>
		<option value='_shipping_country'><?php _e("Shipping Country", 'order-tracking') ?></option>
		<option value='_shipping_email'><?php _e("Shipping Email", 'order-tracking') ?></option>
		<option value='_shipping_phone'><?php _e("Shipping Phone", 'order-tracking') ?></option>
	</select>
	<p><?php _e("If you are important orders from WooCommerce, what field is this equivalent to?", 'order-tracking') ?></p>
</div>

<div class="form-field">
	<label for="Field_Function"><?php _e("Field For?", 'order-tracking') ?></label>
	<select name="Field_Function" id="Field_Function">
		<option value='Orders' selected=selected><?php _e("Orders", 'order-tracking') ?></option>
		<option value='Customers'><?php _e("Customers", 'order-tracking') ?></option>
		<option value='Sales_Reps'><?php _e("Sales Reps", 'order-tracking') ?></option>
	</select>
	<p><?php _e("What should this field apply to: orders, customers or sales reps?", 'order-tracking') ?></p>
</div>

<div class="form-field">
	<label for="Field_Display"><?php _e("Display in Admin Table?", 'order-tracking') ?></label>
	<input type="radio" name="Field_Display" value='Yes' /><?php _e("Yes", 'order-tracking') ?><br />
	<input type="radio" name="Field_Display" value='No' checked=checked /><?php _e("No", 'order-tracking') ?>
</div>

<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Add New Field', 'order-tracking') ?>"  /></p></form>

</div>

<br class="clear" />
</div>
</div><!-- /col-left -->


<?php } else { ?>
<div class="Info-Div">
		<h2><?php _e("Full Version Required!", 'order-tracking') ?></h2>
		<div class="upcp-full-version-explanation">
				<?php _e("The full version of Order Tracking is required to use custom fields.", "UPCP");?><a href="http://www.etoilewebdesign.com/order-tracking/"><?php _e(" Please upgrade to unlock this page!", 'order-tracking'); ?></a>
		</div>
</div>
<?php } ?>
