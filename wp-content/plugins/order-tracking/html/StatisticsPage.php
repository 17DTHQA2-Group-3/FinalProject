<?php if ($EWD_OTP_Full_Version == "Yes") { ?>
<?php

	$Emails_Sent = get_option("EWD_OTP_Emails_Sent");
	if (!is_array($Emails_Sent)) {$Emails_Sent = array();}
	$Links_Checked = get_option("EWD_OTP_Links_Checked");
	if (!is_array($Links_Checked)) {$Links_Checked = array();}
	$Tracking_Links_Checked = get_option("EWD_OTP_Tracking_Links_Checked");
	if (!is_array($Tracking_Links_Checked)) {$Tracking_Links_Checked = array();}
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div><h2>User Statistics</h2>
Add in initial values for the arrays plug statistics days

<div id="col-right">
<div class="col-wrap">
Interactive graphic displaying the data coming soon!
</div>
</div>

<div id="col-left">
<div class="col-wrap">
<h3>Emails Sent</h3>
<table>
<thead>
	<th class='ewd-otp-date'>Date</th>
	<th>Number of Emails Sent</th>
</thead>
<tbody>
<?php
	foreach ($Emails_Sent as $Date => $Sent) {
		echo "<tr>";
		echo "<td class='ewd-otp-date'>" . $Date . "</th>";
		echo "<td class='ewd-otp-count'>" . $Sent . "</th>";
		echo "</tr>";
	}
?>
</tbody>
</table>

<h3>Status Tracking Views</h3>
<table>
<thead>
	<th class='ewd-otp-date'>Date</th>
	<th>Number of Orders Viewed</th>
</thead>
<tbody>
<?php
	foreach ($Links_Checked as $Date => $Sent) {
		echo "<tr>";
		echo "<td class='ewd-otp-date'>" . $Date . "</th>";
		echo "<td class='ewd-otp-count'>" . array_sum($Sent) . "</th>";
		echo "</tr>";
	}
?>
</tbody>
</table>

<h3>Email Tracking Links Clicked</h3>
<table>
<thead>
	<th class='ewd-otp-date'>Date</th>
	<th>Number of Tracking Link Clicks</th>
</thead>
<tbody>
<?php
	foreach ($Tracking_Links_Checked as $Date => $Sent) {
		echo "<tr>";
		echo "<td class='ewd-otp-date'>" . $Date . "</th>";
		echo "<td class='ewd-otp-count'>" . array_sum($Sent) . "</th>";
		echo "</tr>";
	}
?>
</tbody>
</table>

</div>
</div>

</div>

<?php } else { ?>
<div class="Info-Div">
		<h2><?php _e("Full Version Required!", 'order-tracking') ?></h2>
		<div class="upcp-full-version-explanation">
				<?php _e("The full version of Status Tracking is required to use statistics.", "UPCP");?><a href="http://www.etoilewebdesign.com/order-tracking/"><?php _e(" Please upgrade to unlock this page!", 'order-tracking'); ?></a>
		</div>
</div>
<?php } ?>
