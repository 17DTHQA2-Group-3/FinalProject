<?php
add_filter( 'block_categories', 'ewd_otp_add_block_category' );
function ewd_otp_add_block_category( $categories ) {
	$categories[] = array(
		'slug'  => 'ewd-otp-blocks',
		'title' => __( 'Status Tracking', 'order-tracking' ),
	);
	return $categories;
}

