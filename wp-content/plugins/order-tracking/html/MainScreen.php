<div class="EWD_OTP_Menu">
	<h2 class="nav-tab-wrapper">
	<a id="ewd-otp-dash-mobile-menu-open" href="#" class="MenuTab nav-tab"><?php _e("MENU", 'order-tracking'); ?><span id="ewd-otp-dash-mobile-menu-down-caret">&nbsp;&nbsp;&#9660;</span><span id="ewd-otp-dash-mobile-menu-up-caret">&nbsp;&nbsp;&#9650;</span></a>
	<a id="Dashboard_Menu" class="MenuTab nav-tab <?php if ($Display_Page == '' or $Display_Page == 'Dashboard') {echo 'nav-tab-active';}?>" onclick="ShowTab('Dashboard');"><?php _e("Dashboard", 'order-tracking'); ?></a>
	<a id="Orders_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Orders') {echo 'nav-tab-active';}?>" onclick="ShowTab('Orders');"><?php _e("Orders", 'order-tracking'); ?></a>
	<a id="Statuses_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Statuses') {echo 'nav-tab-active';}?>" onclick="ShowTab('Statuses');"><?php _e("Statuses", 'order-tracking'); ?></a>
	<a id="Locations_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Locations') {echo 'nav-tab-active';}?>" onclick="ShowTab('Locations');"><?php _e("Locations", 'order-tracking'); ?></a>
	<a id="SalesReps_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'SalesReps') {echo 'nav-tab-active';}?>" onclick="ShowTab('SalesReps');"><?php _e("Sales Reps", 'order-tracking'); ?></a>
	<a id="Customers_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Customers') {echo 'nav-tab-active';}?>" onclick="ShowTab('Customers');"><?php _e("Customers", 'order-tracking'); ?></a>
	<a id="Emails_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Emails') {echo 'nav-tab-active';}?>" onclick="ShowTab('Emails');"><?php _e("Emails", 'order-tracking'); ?></a>
	<a id="CustomFields_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'CustomFields') {echo 'nav-tab-active';}?>" onclick="ShowTab('CustomFields');"><?php _e("Custom Fields", 'order-tracking'); ?></a>
	<a id="Statistics_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Statistics') {echo 'nav-tab-active';}?>" onclick="ShowTab('Statistics');"><?php _e("Statistics", 'order-tracking'); ?></a>
	<a id="Options_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Options') {echo 'nav-tab-active';}?>" onclick="ShowTab('Options');"><?php _e("Options", 'order-tracking'); ?></a>
	</h2>
</div>
		
<div class="clear"></div>
		
<!-- Add the individual pages to the admin area, and create the active tab based on the selected page -->
<div class="OptionTab <?php if ($Display_Page == "" or $Display_Page == 'Dashboard') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Dashboard">
	<?php include( plugin_dir_path( __FILE__ ) . 'DashboardPage.php'); ?>
</div>
		
<div class="OptionTab <?php if ($Display_Page == 'Orders' or $Display_Page == 'Order') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Orders">
	<?php include( plugin_dir_path( __FILE__ ) . 'OrdersPage.php'); ?>
</div>	

<div class="OptionTab <?php if ($Display_Page == 'Statuses'or $Display_Page == 'Status') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Statuses">
	<?php include( plugin_dir_path( __FILE__ ) . 'StatusesPage.php'); ?>
</div>

<div class="OptionTab <?php if ($Display_Page == 'Locations'or $Display_Page == 'Location') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Locations">
	<?php include( plugin_dir_path( __FILE__ ) . 'LocationsPage.php'); ?>
</div>	

<div class="OptionTab <?php if ($Display_Page == 'SalesReps'or $Display_Page == 'SalesRep') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="SalesReps">
	<?php include( plugin_dir_path( __FILE__ ) . 'SalesRepsPage.php'); ?>
</div>

<div class="OptionTab <?php if ($Display_Page == 'Customers'or $Display_Page == 'Customer') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Customers">
	<?php include( plugin_dir_path( __FILE__ ) . 'CustomersPage.php'); ?>
</div>

<div class="OptionTab <?php if ($Display_Page == 'Emails'or $Display_Page == 'Email') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Emails">
	<?php include( plugin_dir_path( __FILE__ ) . 'EmailsPage.php'); ?>
</div>

<div class="OptionTab <?php if ($Display_Page == 'CustomFields'or $Display_Page == 'CustomField') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="CustomFields">
	<?php include( plugin_dir_path( __FILE__ ) . 'CustomFieldsPage.php'); ?>
</div>

<div class="OptionTab <?php if ($Display_Page == 'Statistics'or $Display_Page == 'Statistic') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Statistics">
	<?php include( plugin_dir_path( __FILE__ ) . 'StatisticsPage.php'); ?>
</div>

<div class="OptionTab <?php if ($Display_Page == 'Options' or $Display_Page == 'Option') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Options">
	<?php include( plugin_dir_path( __FILE__ ) . 'OptionsPage.php'); ?>
</div>		