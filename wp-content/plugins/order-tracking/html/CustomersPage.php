<?php if ($EWD_OTP_Full_Version == "Yes") { ?>
<div id="col-right">
<div class="col-wrap">


<!-- Display a list of the categories which have already been created -->
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>

<?php 
			if (isset($_GET['Page']) and $_GET['DisplayPage'] == "Customers") {$Page = intval( $_GET['Page'] );}
			else {$Page = 1;}

			if ( isset( $_GET['OrderBy'] ) and in_array( $_GET['OrderBy'], array( 'Customer_Name', 'Sales_Rep_ID' ) ) ) { $OrderBy = $_GET['OrderBy']; }
			else { $OrderBy = 'Customer_Name'; }

			$Order = ( isset( $_GET['Order'] ) and $_GET['Order'] == 'DESC' ) ? 'DESC' : 'ASC';

			$Fields = $wpdb->get_results($wpdb->prepare("SELECT Field_ID, Field_Name FROM $EWD_OTP_fields_table_name WHERE Field_Function=%s AND Field_Display=%s", 'Customers', 'Yes'));
			
			$Sql = "SELECT * FROM $EWD_OTP_customers ";
				if (isset($_GET['OrderBy']) and $_GET['DisplayPage'] == "Customers") {$Sql .= "ORDER BY " . $OrderBy . " " . $Order . " ";}
				else {$Sql .= "ORDER BY Customer_Name ";}
				$Sql .= "LIMIT " . ($Page - 1)*20 . ",20";
				$myrows = $wpdb->get_results($Sql);
				$TotalProducts = $wpdb->get_results("SELECT Customer_ID FROM $EWD_OTP_customers");
				$num_rows = $wpdb->num_rows; 
				$Number_of_Pages = ceil($wpdb->num_rows/20);
				$Current_Page_With_Order_By = "admin.php?page=EWD-OTP-options&DisplayPage=Customers";
				if (isset($_GET['OrderBy'])) {$Current_Page_With_Order_By .= "&OrderBy=" . $OrderBy . "&Order=" . $Order;}?>

<form action="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_MassDeleteCustomers&DisplayPage=Customers" method="post">   
<div class="tablenav top">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'order-tracking') ?></option>
						<option value='delete'>Delete</option>
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

<table class="wp-list-table striped widefat fixed tags sorttable" cellspacing="0">
		<thead>
				<tr>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
								<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Customer_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Customers&OrderBy=Customer_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Customers&OrderBy=Customer_Name&Order=ASC'>";} ?>
											  <span><?php _e("Customer Name", 'order-tracking') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='requirements' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Sales_Rep_ID" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Customers&OrderBy=Sales_Rep_ID&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Customers&OrderBy=Sales_Rep_ID&Order=ASC'>";} ?>
											  <span><?php _e("Sales Rep", 'order-tracking') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
					<?php foreach ($Fields as $Field) { ?>
						<th scope='col' id='requirements' class='manage-column column-requirements desc'  style="">
							<span><?php echo $Field->Field_Name; ?></span>
						</th>
					<?php } ?>
				</tr>
		</thead>

		<tfoot>
				<tr>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
								<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Customer_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Customers&OrderBy=Customer_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Customers&OrderBy=Customer_Name&Order=ASC'>";} ?>
											  <span><?php _e("Customer Name", 'order-tracking') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='requirements' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Sales_Rep_ID" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Customers&OrderBy=Sales_Rep_ID&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Customers&OrderBy=Sales_Rep_ID&Order=ASC'>";} ?>
											  <span><?php _e("Sales Rep", 'order-tracking') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
					<?php foreach ($Fields as $Field) { ?>
						<th scope='col' id='requirements' class='manage-column column-requirements desc'  style="">
							<span><?php echo $Field->Field_Name; ?></span>
						</th>
					<?php } ?>
				</tr>
		</tfoot>

	<tbody id="the-list" class='list:tag'>
		
		 <?php  $SalesRepName = "";
				if ($myrows) { 
	  			  foreach ($myrows as $Customer) {
								$SalesRep = $wpdb->get_row("SELECT Sales_Rep_First_Name, Sales_Rep_Last_Name FROM $EWD_OTP_sales_reps WHERE Sales_Rep_ID='" . $Customer->Sales_Rep_ID . "'");
								if (is_object($SalesRep))   {  $SalesRepName = $SalesRep->Sales_Rep_First_Name . " " . $SalesRep->Sales_Rep_Last_Name; }
								echo "<tr id='Item" . $Customer->Customer_ID ."'>";
								echo "<th scope='row' class='check-column'>";
								echo "<input type='checkbox' name='Customers_Bulk[]' value='" . $Customer->Customer_ID ."' />";
								echo "</th>";
								echo "<td class='name column-name'>";
								echo "<strong>";
								echo "<a class='row-title' href='admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_CustomerDetails&Selected=Customer&Customer_ID=" . $Customer->Customer_ID ."' title='Edit " . $Customer->Customer_ID . "'>" . $Customer->Customer_Name . "</a></strong>";
								echo "<br />";
								echo "<div class='row-actions'>";
								/*echo "<span class='edit'>";
								echo "<a href='admin.php?page=EWD-OTP-options&Action=UPCP_Category_Details&Selected=Category&Category_ID=" . $Category->Category_ID ."'>Edit</a>";
		 						echo " | </span>";*/
								echo "<span class='delete'>";
								echo "<a class='delete-tag' href='admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_DeleteCustomer&DisplayPage=Customers&Customer_ID=" . $Customer->Customer_ID ."'>" . __("Delete", 'order-tracking') . "</a>";
		 						echo "</span>";
								echo "</div>";
								echo "<div class='hidden' id='inline_" . $Customer->Customer_ID ."'>";
								echo "<div class='customer-name'>" . $Customer->Customer_Name . "</div>";
								echo "</div>";
								echo "</td>";
								echo "<td class='description column-sales-rep'>" . $SalesRepName . "</td>";
								foreach ($Fields as $Field) {
									$Value = $wpdb->get_var($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Field_ID=%d AND Customer_ID=%d", $Field->Field_ID, $Customer->Customer_ID));
									echo "<td class='description'>" . $Value . "</td>";
								}
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
				<input type="submit" name="" id="doaction" class="button-secondary action" value="Apply"  />
		</div>
		<div class='tablenav-pages <?php if ($Number_of_Pages == 1) {echo "one-page";} ?>'>
				<span class="displaying-num"><?php echo $wpdb->num_rows; ?> <?php _e("items", 'order-tracking') ?></span>
				<span class='pagination-links'>
						<a class='first-page <?php if ($Page == 1) {echo "disabled";} ?>' title='Go to the first page' href='<?php echo esc_attr( $Current_Page_With_Order_By ); ?>&Page=1'>&laquo;</a>
						<a class='prev-page <?php if ($Page < 2) {echo "disabled";} ?>' title='Go to the previous page' href='<?php echo esc_attr( $Current_Page_With_Order_By ); ?>&Page=<?php echo $Page-1;?>'>&lsaquo;</a>
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
</div>

<!-- Form to create a new category -->
<div id="col-left">
<div class="col-wrap">

<div class="form-wrap">
<h3><?php _e("Add a New Customer", 'order-tracking') ?></h3>
<form id="addcat" method="post" action="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_AddCustomer&DisplayPage=Customers" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Add_Customer" />
<?php wp_nonce_field('EWD_OTP_Admin_Nonce', 'EWD_OTP_Admin_Nonce'); ?>
<?php wp_referer_field(); ?>
<div class="form-field form-required">
	<label for="Customer_Name"><?php _e("Customer Name", 'order-tracking') ?></label>
	<input name="Customer_Name" id="Customer_Name" type="text" value="" size="60" />
	<p><?php _e("The name of the customer.", 'order-tracking') ?></p>
</div>
<div class="form-field form-required">
	<label for="Customer_Email"><?php _e("Customer Email", 'order-tracking') ?></label>
	<input name="Customer_Email" id="Customer_Email" type="text" value="" size="60" />
	<p><?php _e("The email address of the customer.", 'order-tracking') ?></p>
</div>
<div class="form-field form-required">
	<label for="Sales_Rep_ID"><?php _e("Sales Rep ID", 'order-tracking') ?></label>
	<input name="Sales_Rep_ID" id="Sales_Rep_ID" type="text" value="" size="60" />
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
			echo "<option value='" . $User->ID . "'>" . $User->display_name . "</option>";
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

unset($ReturnString);
$Value = "";
$ReturnString = "";
foreach ($Fields as $Field) {
		$ReturnString .= "<div class='form-field'><label for='" . $Field->Field_Slug . "'>" . $Field->Field_Name . ":</label>";
		if ($Field->Field_Type == "text" or $Field->Field_Type == "mediumint") {
			  $ReturnString .= "<input name='" . $Field->Field_Slug . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-input' type='text' value='" . $Value . "' />";
		}
		elseif ($Field->Field_Type == "textarea") {
				$ReturnString .= "<textarea name='" . $Field->Field_Slug . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-textarea'>" . $Value . "</textarea>";
		} 
		elseif ($Field->Field_Type == "select") { 
				$Options = explode(",", $Field->Field_Values);
				$ReturnString .= "<select name='" . $Field->Field_Slug . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-select'>";
				foreach ($Options as $Option) {
						$ReturnString .= "<option value='" . $Option . "' ";
						if (trim($Option) == trim($Value)) {$ReturnString .= "selected='selected'";}
						$ReturnString .= ">" . $Option . "</option>";
				}
				$ReturnString .= "</select>";
		} 
		elseif ($Field->Field_Type == "radio") {
				$Counter = 0;
				$Options = explode(",", $Field->Field_Values);
				foreach ($Options as $Option) {
						if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
						$ReturnString .= "<input type='radio' name='" . $Field->Field_Slug . "' value='" . $Option . "' class='ewd-otp-radio' ";
						if (trim($Option) == trim($Value)) {$ReturnString .= "checked";}
						$ReturnString .= ">" . $Option;
						$Counter++;
				}
		} 
		elseif ($Field->Field_Type == "checkbox") {
  			$Counter = 0;
				$Options = explode(",", $Field->Field_Values);
				$Values = explode(",", $Value);
				foreach ($Options as $Option) {
						if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
						$ReturnString .= "<input type='checkbox' name='" . $Field->Field_Slug . "[]' value='" . $Option . "' class='ewd-otp-checkbox' ";
						if (in_array($Option, $Values)) {$ReturnString .= "checked";}
						$ReturnString .= ">" . $Option . "</br>";
						$Counter++;
				}
		}
		elseif ($Field->Field_Type == "file" or $Field->Field_Type == "picture") {
				$ReturnString .= "<input name='" . $Field->Field_Slug . "' class='ewd-otp-file-input' type='file' value='' />";
		}
		elseif ($Field->Field_Type == "date") {
				$ReturnString .= "<input name='" . $Field->Field_Slug . "' class='ewd-otp-date-input' type='date' value='' />";
		} 
		elseif ($Field->Field_Type == "datetime") {
				$ReturnString .= "<input name='" . $Field->Field_Slug . "' class='ewd-otp-datetime-input' type='datetime-local' value='' />";
  	}
		$ReturnString .= " </div>";
}
echo $ReturnString;

?>

<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Add New Customer', 'order-tracking') ?>"  /></p></form></div>
<br class="clear" />
</div>
</div>

<?php } else { ?>
<div class="Info-Div">
		<h2><?php _e("Full Version Required!", 'order-tracking') ?></h2>
		<div class="upcp-full-version-explanation">
				<?php _e("The full version of Order Tracking is required to use the customers feature.", "UPCP");?><a href="http://www.etoilewebdesign.com/order-tracking/"><?php _e(" Please upgrade to unlock this page!", 'order-tracking'); ?></a>
		</div>
</div>
<?php } ?>


	<!--<form method="get" action=""><table style="display: none"><tbody id="inlineedit">
		<tr id="inline-edit" class="inline-edit-row" style="display: none"><td colspan="4" class="colspanchange">

			<fieldset><div class="inline-edit-col">
				<h4>Quick Edit</h4>

				<label>
					<span class="title">Name</span>
					<span class="input-text-wrap"><input type="text" name="name" class="ptitle" value="" /></span>
				</label>
					<label>
					<span class="title">Slug</span>
					<span class="input-text-wrap"><input type="text" name="slug" class="ptitle" value="" /></span>
				</label>
				</div></fieldset>
	
		<p class="inline-edit-save submit">
			<a accesskey="c" href="#inline-edit" title="Cancel" class="cancel button-secondary alignleft">Cancel</a>
						<a accesskey="s" href="#inline-edit" title="Update Level" class="save button-primary alignright">Update Level</a>
			<img class="waiting" style="display:none;" src="<?php echo ABSPATH . 'wp-admin/images/wpspin_light.gif'?>" alt="" />
			<span class="error" style="display:none;"></span>
			<input type="hidden" id="_inline_edit" name="_inline_edit" value="fb59c3f3d1" />			<input type="hidden" name="taxonomy" value="wmlevel" />
			<input type="hidden" name="post_type" value="post" />
			<br class="clear" />
		</p>
		</td></tr>
		</tbody></table></form>-->
		
<!--</div>-->
		