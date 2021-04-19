<?php

function EWD_OTP_Remove_Old_Statistics() {
	$Statistics_Days = get_option("EWD_OTP_Statistics_Days");

	$Emails_Sent = get_option("EWD_OTP_Emails_Sent");
	if (!is_array($Emails_Sent)) {$Emails_Sent = array();}
	$Links_Checked = get_option("EWD_OTP_Links_Checked");
	if (!is_array($Links_Checked)) {$Links_Checked = array();}
	$Tracking_Links_Checked = get_option("EWD_OTP_Tracking_Links_Checked");
	if (!is_array($Tracking_Links_Checked)) {$Tracking_Links_Checked = array();}

	$Counter = 0;
	while ($Counter <= $Statistics_Days) {
		$Dates_To_Save[] = date("Y-m-d", time() - ($Counter*24*60*60));
		$Counter++;
	}

	$New_Emails_Sent = array_intersect_key($Emails_Sent, $Dates_To_Save);
	$New_Links_Checked = array_intersect_key($Links_Checked, $Dates_To_Save);
	$New_Tracking_Links_Checked = array_intersect_key($Tracking_Links_Checked, $Dates_To_Save);

	update_option("EWD_OTP_Emails_Sent", $New_Emails_Sent);
	update_option("EWD_OTP_Links_Checked", $New_Links_Checked);
	update_option("EWD_OTP_Tracking_Links_Checked", $New_Tracking_Links_Checked);

	update_option("EWD_OTP_Remove_Old_Statistics_Checked", date("Y-m-d"));
}



?>