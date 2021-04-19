<?php

function EWD_OTP_add_ob_start() {
    ob_start();
}
add_action('init', 'EWD_OTP_add_ob_start', 1);

function EWD_OTP_flush_ob_end() {
	if (ob_get_level() > 0){
		ob_end_flush();
	}
}
add_action('shutdown', 'EWD_OTP_flush_ob_end');

?>