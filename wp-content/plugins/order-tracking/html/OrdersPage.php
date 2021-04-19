<?php 
$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
if (!is_array($Statuses_Array)) {$Statuses_Array = array();}
$Locations_Array = get_option("EWD_OTP_Locations_Array");
if (!is_array($Locations_Array)) {$Locations_Array = array();}
$Allow_Order_Payments = get_option("EWD_OTP_Allow_Order_Payments");

$Order_Information = get_option("EWD_OTP_Order_Information");

?>
<div id="col-right" class="ewd-otp-admin-products-table-full">
<div class="col-wrap">

<div class="ewd-otp-admin-new-product-page-top-part">
	<div class="ewd-otp-admin-new-product-page-top-part-left">
		<h3 class="ewd-otp-admin-new-tab-headings"><?php _e('Add New Order', 'order-tracking'); ?></h3>	
		<div class="ewd-otp-admin-add-new-product-buttons-area">
			<a href="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_Order_Details" class="button-primary ewd-otp-admin-add-new-product-button" id="ewd-otp-admin-manually-add-product-button"><?php _e('Manually', 'order-tracking'); ?></a>
			<div class="button-primary ewd-otp-admin-add-new-product-button" id="ewd-otp-admin-add-by-spreadsheet-button"><?php _e('From Spreadsheet', 'order-tracking'); ?></div>
		</div>
	</div>
	<div class="ewd-otp-admin-new-product-page-top-part-right">
		<h3 class="ewd-otp-admin-new-tab-headings"><?php _e('Export Orders to Spreasheet', 'order-tracking'); ?></h3>	
		<div class="ewd-otp-admin-export-buttons-area">
			<?php if($EWD_OTP_Full_Version == 'Yes'){ ?>
				<form method="post" action="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_ExportToExcel">
					<input type="submit" name="Export_Submit" class="button button-secondary ewd-otp-admin-export-button" value="<?php _e('Export to Excel', 'order-tracking'); ?>"  />
				</form>
			<?php } else{
				_e("The full version of the Status Tracking Plugin is required to export products.", 'order-tracking'); ?><br /><a href="https://www.etoilewebdesign.com/plugins/order-tracking/#buy" target="_blank"><?php _e("Please upgrade to unlock this feature!", 'order-tracking'); ?></a>
			<?php } ?>
		</div>
	</div>
</div>

<?php //echo get_option('plugin_error'); ?>
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>

<?php 
			$Fields = $wpdb->get_results($wpdb->prepare("SELECT Field_ID, Field_Name FROM $EWD_OTP_fields_table_name WHERE Field_Function=%s AND Field_Display=%s", 'Orders', 'Yes'));
			$Customers = $wpdb->get_results("SELECT * FROM $EWD_OTP_customers");
			$Sales_Reps = $wpdb->get_results("SELECT * FROM $EWD_OTP_sales_reps");
			if ($Sales_Rep_Only == "Yes") {
				$Current_User = wp_get_current_user();
				$Sql = "SELECT Sales_Rep_ID FROM $EWD_OTP_sales_reps WHERE Sales_Rep_WP_ID='" . $Current_User->ID . "'";
				$Sales_Rep_ID = $wpdb->get_var($Sql);
			}
			
			if (isset($_GET['Page'])) {$Page = intval( $_GET['Page'] );}
			else {$Page = 1;}

			if ( isset( $_GET['OrderBy'] ) and in_array( $_GET['OrderBy'], array( 'Order_Number', 'Order_Name', 'Order_Status', 'Order_Customer_Notes', 'Order_Status_Updated' ) ) ) { $OrderBy = $_GET['OrderBy']; }
			else { $OrderBy = 'Order_Number'; }

			$Order = ( isset( $_GET['Order'] ) and $_GET['Order'] == 'DESC' ) ? 'DESC' : 'ASC';
			
			$Sql = "SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_ID!='0' ";
				if (!isset($_REQUEST['OrderNumber']) and !isset($_REQUEST['Show_Hidden_Orders'])) {$Sql .= "AND Order_Display='Yes' ";}
				if (isset($_REQUEST['OrderNumber'])) {$Sql .= "AND Order_Number LIKE '%" . esc_sql( $_REQUEST['OrderNumber'] ) . "%' ";}
				if ($Sales_Rep_Only == "Yes") {$Sql .= " AND Sales_Rep_ID='" . $Sales_Rep_ID . "'";}
				if (isset($_GET['OrderBy']) and $_GET['DisplayPage'] == "Orders") {$Sql .= "ORDER BY " . $OrderBy . " " . $Order . " ";}
				else {$Sql .= "ORDER BY Order_Number ";}
				$Sql .= "LIMIT " . ($Page - 1)*20 . ",20";
				$myrows = $wpdb->get_results($Sql);
				if ($Sales_Rep_Only == "Yes") {$Sql = "SELECT Order_ID FROM $EWD_OTP_orders_table_name WHERE Sales_Rep_ID='" . $Sales_Rep_ID . "'" . (!isset($_REQUEST['Show_Hidden_Orders']) ? " AND Order_Display='Yes'" : "" );}
				else {$Sql = "SELECT Order_ID FROM $EWD_OTP_orders_table_name" . (!isset($_REQUEST['Show_Hidden_Orders']) ? " WHERE Order_Display='Yes'" : "" );}
				$TotalOrders = $wpdb->get_results($Sql);
				$TotalOrderCount = $wpdb->num_rows;
				$Number_of_Pages = ceil($TotalOrderCount/20);
				$Current_Page = "admin.php?page=EWD-OTP-options&DisplayPage=Orders";
				if (isset($_REQUEST['OrderNumber'])) {$Current_Page .= "&OrderNumber=" . sanitize_text_field( $_REQUEST['OrderNumber'] );}
				if (isset($_REQUEST['Show_Hidden_Orders'])) {$Current_Page .= "&Show_Hidden_Orders=Yes";}
				if (isset($_GET['OrderBy'])) {$Current_Page_With_Order_By = $Current_Page . "&OrderBy=" .$OrderBy . "&Order=" . $Order;}
				else {$Current_Page_With_Order_By = $Current_Page;}
				?>

<form action="admin.php?page=EWD-OTP-options&DisplayPage=Orders" method="post">    
<div class="ewd-otp-admin-search-orders">
	<div class="ewd-otp-admin-search-orders-inside">
		<label class="screen-reader-text" for="post-search-input">Search Orders:</label>
		<input type="submit" name="" id="search-submit" class="button ewd-otp-admin-search-orders-box" value="Search Orders">
		<input type="search" class="ewd-otp-admin-search-orders-input" id="post-search-input" name="OrderNumber" value="">
	</div>
	<div class="ewd-otp-admin-search-orders-inside">
		<a class='confirm button-secondary action ewd-otp-admin-delete-all-products-button' href='admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_DeleteAllOrders&DisplayPage=Orders'>Delete All Orders</a>
		<input type="submit" name="Show_Hidden_Orders" class='button ewd-otp-margin-top-8 ewd-otp-admin-show-hidden-button' id="hidden-submit" class="button" value="Show Hidden Orders">
	</div>
</div>
</form>
<form action="admin.php?page=EWD-OTP-options&DisplayPage=Orders&OTPAction=EWD_OTP_MassAction" method="post"> 
<div class="tablenav top">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'order-tracking') ?></option>
  						<?php 
							foreach ($Statuses_Array as $Status_Array_Item) { ?>
							<option value='<?php echo $Status_Array_Item['Status']; ?>'><?php echo $Status_Array_Item['Status']; ?></option>
						<?php } ?>
						<option value='hide'><?php _e("Hide Order", 'order-tracking') ?></option>
						<option value='delete'><?php _e("Delete", 'order-tracking') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'order-tracking') ?>"  />
		</div>
		<div class='tablenav-pages <?php if ($Number_of_Pages == 1) {echo "one-page";} ?>'>
				<span class="displaying-num"><?php echo $TotalOrderCount; ?> <?php _e("items", 'order-tracking') ?></span>
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
			<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
				<input type="checkbox" /></th><th scope='col' id='field-name' class='manage-column column-name sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Number" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Number&Order=DESC'>";}
					else {echo "<a href='" . $Current_Page . "&OrderBy=Order_Number&Order=ASC'>";} 
				?>
					<span><?php _e("Order Number", 'order-tracking') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='type' class='manage-column column-type sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Name&Order=DESC'>";}
					else {echo "<a href='" . $Current_Page . "&OrderBy=Order_Name&Order=ASC'>";} 
				?>
					<span><?php _e("Name", 'order-tracking') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Status&Order=DESC'>";}
					else {echo "<a href='" . $Current_Page . "&OrderBy=Order_Status&Order=ASC'>";} 
				?>
					<span><?php _e("Status", 'order-tracking') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<?php if (is_array($Order_Information) and in_array("Customer_Notes", $Order_Information)) { ?>
				<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
					<?php 
						if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Customer_Notes&Order=DESC'>";}
						else {echo "<a href='" . $Current_Page . "&OrderBy=Order_Customer_Notes&Order=ASC'>";} 
					?>
						<span><?php _e("Customer Notes", 'order-tracking') ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
			<?php } ?>
			<th scope='col' id='required' class='manage-column column-users sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status_Updated" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Status_Updated&Order=DESC'>";}
					else {echo "<a href='" . $Current_Page . "&OrderBy=Order_Status_Updated&Order=ASC'>";} 
				?>
					<span><?php _e("Updated", 'order-tracking') ?></span>
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
			<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
				<input type="checkbox" /></th><th scope='col' id='field-name' class='manage-column column-name sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Number" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Number&Order=DESC'>";}
					else {echo "<a href='" . $Current_Page . "&OrderBy=Order_Number&Order=ASC'>";} 
				?>
					<span><?php _e("Order Number", 'order-tracking') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='type' class='manage-column column-type sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Name&Order=DESC'>";}
					else {echo "<a href='" . $Current_Page . "&OrderBy=Order_Name&Order=ASC'>";} 
				?>
					<span><?php _e("Name", 'order-tracking') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Status&Order=DESC'>";}
					else {echo "<a href='" . $Current_Page . "&OrderBy=Order_Status&Order=ASC'>";} 
				?>
					<span><?php _e("Status", 'order-tracking') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<?php if (is_array($Order_Information) and in_array("Customer_Notes", $Order_Information)) { ?>
				<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
					<?php 
						if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Customer_Notes&Order=DESC'>";}
						else {echo "<a href='" . $Current_Page . "&OrderBy=Order_Customer_Notes&Order=ASC'>";} 
					?>
						<span><?php _e("Customer Notes", 'order-tracking') ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
			<?php } ?>
			<th scope='col' id='required' class='manage-column column-users sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status_Updated" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=EWD-OTP-options&DisplayPage=Orders&OrderBy=Order_Status_Updated&Order=DESC'>";}
					else {echo "<a href='" . $Current_Page . "&OrderBy=Order_Status_Updated&Order=ASC'>";} 
				?>
					<span><?php _e("Updated", 'order-tracking') ?></span>
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
		
		 <?php
				if ($myrows) { 
	  			  foreach ($myrows as $Order) {
								echo "<tr id='Order" . $Order->Order_ID ."'>";
								echo "<th scope='row' class='check-column'>";
								echo "<input type='checkbox' name='Orders_Bulk[]' value='" . $Order->Order_ID ."' />";
								echo "</th>";
								echo "<td class='name column-name'>";
								echo "<strong>";
								echo "<a class='row-title' href='admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_Order_Details&Selected=Order&Order_ID=" . $Order->Order_ID ."' title='Edit " . $Order->Order_Number . "'>" . $Order->Order_Number . "</a></strong>";
								echo "<br />";
								echo "<div class='row-actions'>";
								echo "<span class='delete'>";
								echo "<a class='delete-tag' href='admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_HideOrder&DisplayPage=Orders&Order_ID=" . $Order->Order_ID ."'>" . __("Hide", 'order-tracking') . "</a>";
		 						echo "</span>";
								echo "</div>";
								echo "<div class='hidden' id='inline_" . $Order->Order_ID ."'>";
								echo "<div class='number'>" . stripslashes($Order->Order_Number) . "</div>";
								echo "</div>";
								echo "</td>";
								echo "<td class='name column-name'>" . stripslashes($Order->Order_Name) . "</td>";
								echo "<td class='status column-status'>" . stripslashes($Order->Order_Status) . "</td>";
								if (is_array($Order_Information) and in_array("Customer_Notes", $Order_Information)) {echo "<td class='customer-notes column-notes'>" . stripslashes($Order->Order_Customer_Notes) . "</td>";}
								echo "<td class='updated column-updated'>" . stripslashes($Order->Order_Status_Updated) . "</td>";
								foreach ($Fields as $Field) {
									$Value = $wpdb->get_var($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Field_ID=%d AND Order_ID=%d", $Field->Field_ID, $Order->Order_ID));
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
		</div>
		<div class='tablenav-pages <?php if ($Number_of_Pages == 1) {echo "one-page";} ?>'>
				<span class="displaying-num"><?php echo $TotalOrderCount; ?> <?php _e("items", 'order-tracking') ?></span>
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
</div>

<div id="col-left" class="otp-hidden">
<div class="col-wrap">

<div class="form-wrap">

<div id="ewd-otp-admin-add-manually">

<h2><?php _e("Add New Order", 'order-tracking') ?></h2>
<!-- Form to create a new order -->
<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_AddOrder&DisplayPage=Orders" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Add_Order" />
<?php wp_nonce_field('EWD_OTP_Admin_Nonce', 'EWD_OTP_Admin_Nonce'); ?>
<?php wp_referer_field(); ?>
<div class="form-field form-required">
	<label for="Order_Name"><?php _e("Name", 'order-tracking') ?></label>
	<input name="Order_Name" id="Order_Name" type="text" value="" size="60" />
	<p><?php _e("The name of the order your users will see.", 'order-tracking') ?></p>
</div>
<div class="form-field">
	<label for="Order_Number"><?php _e("Order Number", 'order-tracking') ?></label>
	<input name="Order_Number" id="Order_Number" />
	<p><?php _e("The number that visitors will search to find the order.", 'order-tracking') ?></p>
</div>
<div class="form-field">
	<label for="Order_Email"><?php _e("Order Email", 'order-tracking') ?></label>
	<input type='text' name="Order_Email" id="Order_Email" />
	<p><?php _e("The e-mail address to send order updates to, if you have selected that option.", 'order-tracking') ?></p>
</div>
<div>
		<label for="Order_Status"><?php _e("Order Status", 'order-tracking') ?></label>
		<select name="Order_Status" id="Order_Status" />
		<?php if (!is_array($Statuses_Array)) {$Statuses_Array = array();}
			foreach ($Statuses_Array as $Status_Array_Item) { ?>
			<option value='<?php echo $Status_Array_Item['Status']; ?>'><?php echo $Status_Array_Item['Status']; ?></option>
		<?php } ?>
		</select>
		<p><?php _e("The status that visitors will see if they enter the order number.", 'order-tracking') ?></p>
</div>
<div>
		<label for="Order_Location"><?php _e("Order Location", 'order-tracking') ?></label>
		<select name="Order_Location" id="Order_Location" />
		<?php foreach ($Locations_Array as $Location_Array_Item) { ?>
			<option value="<?php echo $Location_Array_Item['Name']; ?>">
				<?php echo $Location_Array_Item['Name']; ?><?php if ($Location_Array_Item['Latitude'] != "") {echo " (" . $Location_Array_Item['Latitude'] . ", " . $Location_Array_Item['Longitude'] . ")";} ?>
			</option>
		<?php } ?>
		</select>
		<p><?php _e("The location that visitors will see if they enter the order number.", 'order-tracking') ?></p>
</div>
<div>
		<label for="Customer_ID"><?php _e("Customer", 'order-tracking') ?></label>
		<select name="Customer_ID" id="Customer_ID" />
		<option value='0'>None</option>
		<?php foreach ($Customers as $Customer) { ?>
			<option value='<?php echo $Customer->Customer_ID; ?>'><?php echo $Customer->Customer_Name; ?></option>
		<?php } ?>
		</select>
		<p><?php _e("The customer that this order is associated with.", 'order-tracking') ?></p>
</div>
<?php 
	if ($Sales_Rep_Only == "Yes") {
		echo "<input type='hidden' name='Sales_Rep_ID' value='" . $Sales_Rep_ID . "' />";
	}
	else {
?>
<div>
		<label for="Sales_Rep_ID"><?php _e("Sales Rep", 'order-tracking') ?></label>
		<select name="Sales_Rep_ID" id="Sales_Rep_ID" />
		<option value='0'>None</option>
		<?php foreach ($Sales_Reps as $Sales_Rep) { ?>
					<option value='<?php echo $Sales_Rep->Sales_Rep_ID; ?>'><?php echo $Sales_Rep->Sales_Rep_First_Name . " " . $Sales_Rep->Sales_Rep_Last_Name; ?></option>
		<?php } ?>
		</select>
		<p><?php _e("The sales rep that this order is associated with.", 'order-tracking') ?></p>
</div>
<?php } ?>
<?php if ($Allow_Order_Payments == "Yes") { ?>
	<div class="form-field">
		<label for="Order_Payment_Price"><?php _e("Order Payment Price", 'order-tracking') ?></label>
		<input type='text' name="Order_Payment_Price" id="Order_Payment_Price" />
		<p><?php _e("The amount that should be paid via PayPal for this order.", 'order-tracking') ?></p>
	</div>
	<div>
		<label for="Order_Payment_Completed"><?php _e("Payment Completed?", 'order-tracking') ?></label>
		<input type='radio' name="Order_Payment_Completed" value="Yes">Yes<br/>
		<input type='radio' name="Order_Payment_Completed" value="No" checked>No<br/>
		<p><?php _e("Has the payment for this order been made? This field should automatically update when payment is made for this order.", 'order-tracking') ?></p>
</div>
	<div class="form-field">
		<label for="Order_PayPal_Receipt_Number"><?php _e("PayPal Transaction ID", 'order-tracking') ?></label>
		<input type='text' name="Order_PayPal_Receipt_Number" id="Order_PayPal_Receipt_Number" />
		<p><?php _e("The transaction ID generated by PayPal for this order once th payment is made (leave blank until payment is made).", 'order-tracking') ?></p>
	</div>
<?php } ?>
<div>
		<label for="Order_Notes_Public"><?php _e("Public Order Notes", 'order-tracking') ?></label>
		<input name="Order_Notes_Public" id="Order_Notes_Public" />
		<p><?php _e("The notes that visitors will see if they enter the order number, and you've included 'Notes' on the options page.", 'order-tracking') ?></p>
</div>
<div>
		<label for="Order_Notes_Private"><?php _e("Private Order Notes", 'order-tracking') ?></label>
		<input name="Order_Notes_Private" id="Order_Notes_Private" />
		<p><?php _e("The notes about an order visible only to admins.", 'order-tracking') ?></p>
</div>
<div>
		<label for="Order_Display"><?php _e("Show in Admin Table?", 'order-tracking') ?></label>
		<input type='radio' name="Order_Display" value="Yes" checked>Yes<br/>
		<input type='radio' name="Order_Display" value="No">No<br/>
		<p><?php _e("Should this order appear in the orders table in the admin area?", 'order-tracking') ?></p>
</div>

<?php
$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Orders'";
$Fields = $wpdb->get_results($Sql);
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

<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Add New Order', 'order-tracking') ?>"  /></p></form>

</div> <!-- ewd-otp-admin-add-manually -->


<div id="ewd-otp-admin-add-from-spreadsheet">
	<h3><?php _e("Add/Update Orders from Spreadsheet", 'order-tracking') ?></h3>
	<?php if ($EWD_OTP_Full_Version == "Yes") { ?>
	<form id="addtag" method="post" action="admin.php?page=EWD-OTP-options&OTPAction=EWD_OTP_AddOrderSpreadsheet&DisplayPage=Orders" class="validate" enctype="multipart/form-data">
	
	<?php wp_nonce_field( 'EWD_OTP_Import', 'EWD_OTP_Import_Nonce' );  ?>

	<div class="form-field form-required">
			<input name="Orders_Spreadsheet" id="Orders_Spreadsheet" type="file" value=""/>
			<p><?php _e("The spreadsheet containing the orders you wish to add. Make sure that the column title names are the same as the field names for orders (ex: Name, Number, Status, etc.), and that any statuses are written exactly the same as they are online. To update an order, make sure the order numbers are exactly the same.", 'order-tracking') ?></p>
	</div>
	<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Add New Orders', 'order-tracking') ?>"  /></p>
	</form>
	<?php } else { ?>
	<div class="Info-Div">
			<h2><?php _e("Full Version Required!", 'order-tracking') ?></h2>
			<div class="upcp-full-version-explanation">
					<?php _e("The full version of Order Tracking is required to use spreadsheet uploads.", 'order-tracking');?><a href="http://www.etoilewebdesign.com/order-tracking/"><?php _e(" Please upgrade to unlock this page!", 'order-tracking'); ?></a>
			</div>
	</div>
	<?php } ?>
</div>


</div>


<br class="clear" />
</div>
</div><!-- /col-left -->
