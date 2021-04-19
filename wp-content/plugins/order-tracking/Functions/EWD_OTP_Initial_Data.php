<?php
function EWD_OTP_Output_Welcome_Screen() {
	include EWD_OTP_CD_PLUGIN_PATH . 'html/WelcomeScreen.php';
}

function EWD_OTP_Initial_Install_Screen() {
	add_dashboard_page(
			esc_html__( 'Order Tracking - Welcome!', 'order-tracking' ),
			esc_html__( 'Order Tracking - Welcome!', 'order-tracking' ),
			'manage_options',
			'ewd-otp-getting-started',
			'EWD_OTP_Output_Welcome_Screen'
		);
}

function EWD_OTP_Remove_Install_Screen_Admin_Menu() {
	remove_submenu_page( 'index.php', 'ewd-otp-getting-started' );
}

function EWD_OTP_Welcome_Screen_Redirect() {
	global $wpdb;
	global $EWD_OTP_orders_table_name;

	if ( ! get_transient( 'ewd-otp-getting-started' ) ) {
		return;
	}
	
	delete_transient( 'ewd-otp-getting-started' );

	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}

	$Orders = $wpdb->get_results("SELECT Order_ID FROM $EWD_OTP_orders_table_name");
	$Orders_Count = $wpdb->num_rows;

	if ($Orders_Count) {
		set_transient('ewd-otp-admin-install-notice', true, 5);
		return;
	}

	wp_safe_redirect( admin_url( 'index.php?page=ewd-otp-getting-started' ) );
	exit;
}

add_action( 'admin_menu', 'EWD_OTP_Initial_Install_Screen' );
add_action( 'admin_head', 'EWD_OTP_Remove_Install_Screen_Admin_Menu' );
add_action( 'admin_init', 'EWD_OTP_Welcome_Screen_Redirect', 9999 );
?>