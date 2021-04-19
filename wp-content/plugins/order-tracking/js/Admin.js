/* Used to show and hide the admin tabs for otp */
function ShowTab(TabName) {
		jQuery(".OptionTab").each(function() {
				jQuery(this).addClass("HiddenTab");
				jQuery(this).removeClass("ActiveTab");
		});
		jQuery("#"+TabName).removeClass("HiddenTab");
		jQuery("#"+TabName).addClass("ActiveTab");
		
		jQuery(".nav-tab").each(function() {
				jQuery(this).removeClass("nav-tab-active");
		});
		jQuery("#"+TabName+"_Menu").addClass("nav-tab-active");
}

jQuery(document).ready(function() {
	jQuery('.custom-fields-list').sortable({
		items: '.custom-field-list-item',
		opacity: 0.6,
		cursor: 'move',
		axis: 'y',
		update: function() {
			var order = jQuery(this).sortable('serialize') + '&action=ewd_otp_custom_fields_update_order';
			jQuery.post(ajaxurl, order, function(response) {});
		}
	});
});

function ShowOptionTab(TabName) {
	jQuery(".otp-option-set").each(function() {
		jQuery(this).addClass("otp-hidden");
	});
	jQuery("#"+TabName).removeClass("otp-hidden");
	
	// var activeContentHeight = jQuery("#"+TabName).innerHeight();
	// jQuery(".otp-options-page-tabbed-content").animate({
	// 	'height':activeContentHeight
	// 	}, 500);
	// jQuery(".otp-options-page-tabbed-content").height(activeContentHeight);

	jQuery(".options-subnav-tab").each(function() {
		jQuery(this).removeClass("options-subnav-tab-active");
	});
	jQuery("#"+TabName+"_Menu").addClass("options-subnav-tab-active");
	jQuery('input[name="Display_Tab"]').val(TabName);
}

jQuery(document).ready(function() {
	SetMessageDeleteHandlers();

	jQuery('.ewd-otp-add-email').on('click', function(event) {
		var ID = jQuery(this).data('nextid');

		var HTML = "<tr id='ewd-otp-email-message-" + ID + "'>";
		HTML += "<td><input type='text' name='Email_Message_" + ID + "_Name'></td>";
		HTML += "<td><textarea class='ewd-otp-array-textarea' name='Email_Message_" + ID + "_Body'></textarea></td>";
		HTML += "<td><a class='ewd-otp-delete-message' data-messagenumber='" + ID + "'>Delete</a></td>";
		HTML += "</tr>";

		//jQuery('table > tr#ewd-uasp-add-reminder').before(HTML);
		jQuery('#ewd-otp-email-messages-table tr:last').before(HTML);

		ID++;
		jQuery(this).data('nextid', ID); //updates but doesn't show in DOM

		SetMessageDeleteHandlers();

		event.preventDefault();
	});
});

function SetMessageDeleteHandlers() {
	jQuery('.ewd-otp-delete-message').on('click', function(event) {
		var ID = jQuery(this).data('messagenumber');
		var tr = jQuery('#ewd-otp-email-message-'+ID);

		tr.fadeOut(400, function(){
            tr.remove();
        });

		event.preventDefault();
	});
}

jQuery(document).ready(function() {
	jQuery('input#Field_Name').on('focusout', function() {
		if (jQuery('input#Field_Slug').val() == "") {
			var Name = jQuery(this).val();
			var Name2 = Name.replace(/ /g, '-');
			var Name3 = Name2.toLowerCase();
			var Slug = Name3.replace(/[\/\\\[\]|&;$%@"<>()+,^#*{}'!=:?]/g, "");
			jQuery('input#Field_Slug').val(Slug);
		}
	})
});

jQuery(document).ready(function() {
	jQuery('.ewd-otp-spectrum').spectrum({
		showInput: true,
		showInitial: true,
		preferredFormat: "hex",
		allowEmpty: true
	});

	jQuery('.ewd-otp-spectrum').css('display', 'inline');

	jQuery('.ewd-otp-spectrum').on('change', function() {
		if (jQuery(this).val() != "") {
			jQuery(this).css('background', jQuery(this).val());
			var rgb = EWD_OTP_hexToRgb(jQuery(this).val());
			var Brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
			if (Brightness < 100) {jQuery(this).css('color', '#ffffff');}
			else {jQuery(this).css('color', '#000000');}
		}
		else {
			jQuery(this).css('background', 'none');
		}
	});

	jQuery('.ewd-otp-spectrum').each(function() {
		if (jQuery(this).val() != "") {
			jQuery(this).css('background', jQuery(this).val());
			var rgb = EWD_OTP_hexToRgb(jQuery(this).val());
			var Brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
			if (Brightness < 100) {jQuery(this).css('color', '#ffffff');}
			else {jQuery(this).css('color', '#000000');}
		}
	});
});

function EWD_OTP_hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}


//NEW DASHBOARD MOBILE MENU AND WIDGET TOGGLING
jQuery(document).ready(function($){
	$('#ewd-otp-dash-mobile-menu-open').click(function(){
		$('.EWD_OTP_Menu .nav-tab:nth-of-type(1n+2)').toggle();
		$('#ewd-otp-dash-mobile-menu-up-caret').toggle();
		$('#ewd-otp-dash-mobile-menu-down-caret').toggle();
		return false;
	});
	$(function(){
		$(window).resize(function(){
			if($(window).width() > 785){
				$('.EWD_OTP_Menu .nav-tab:nth-of-type(1n+2)').show();
			}
			else{
				$('.EWD_OTP_Menu .nav-tab:nth-of-type(1n+2)').hide();
				$('#ewd-otp-dash-mobile-menu-up-caret').hide();
				$('#ewd-otp-dash-mobile-menu-down-caret').show();
			}
		}).resize();
	});	
	$('#ewd-otp-dashboard-support-widget-box .ewd-otp-dashboard-new-widget-box-top').click(function(){
		$('#ewd-otp-dashboard-support-widget-box .ewd-otp-dashboard-new-widget-box-bottom').toggle();
		$('#ewd-otp-dash-mobile-support-up-caret').toggle();
		$('#ewd-otp-dash-mobile-support-down-caret').toggle();
	});
	$('#ewd-otp-dashboard-optional-table .ewd-otp-dashboard-new-widget-box-top').click(function(){
		$('#ewd-otp-dashboard-optional-table .ewd-otp-dashboard-new-widget-box-bottom').toggle();
		$('#ewd-otp-dash-optional-table-up-caret').toggle();
		$('#ewd-otp-dash-optional-table-down-caret').toggle();
	});
});


//REVIEW ASK POP-UP
jQuery(document).ready(function() {
    jQuery('.ewd-otp-hide-review-ask').on('click', function() {
        var Ask_Review_Date = jQuery(this).data('askreviewdelay');

        jQuery('.ewd-otp-review-ask-popup, #ewd-otp-review-ask-overlay').addClass('otp-hidden');

        var data = 'Ask_Review_Date=' + Ask_Review_Date + '&action=ewd_otp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
    });
    jQuery('#ewd-otp-review-ask-overlay').on('click', function() {
    	jQuery('.ewd-otp-review-ask-popup, #ewd-otp-review-ask-overlay').addClass('otp-hidden');
    })
});


//OPTIONS HELP/DESCRIPTION TEXT
jQuery(document).ready(function($) {
	$('.otp-option-set .form-table tr').each(function(){
		var thisOptionClick = $(this);
		thisOptionClick.find('th').click(function(){
			thisOptionClick.find('td p').toggle();
		});
	});
	$('.ewdOptionHasInfo').each(function(){
		var thisNonTableOptionClick = $(this);
		thisNonTableOptionClick.find('.ewd-otp-admin-styling-subsection-label').click(function(){
			thisNonTableOptionClick.find('fieldset p').toggle();
		});
	});
	$('.toplevel_page_EWD-OTP-options #Emails .form-table tr').each(function(){
		var thisEmailsPageOptionClick = $(this);
		thisEmailsPageOptionClick.find('th').click(function(){
			thisEmailsPageOptionClick.find('td p').toggle();
		});
	});
	$(function(){
		$(window).resize(function(){
			$('.otp-option-set .form-table tr').each(function(){
				var thisOption = $(this);
				if( $(window).width() < 783 ){
					if( thisOption.find('.ewd-otp-admin-hide-radios').length > 0 ) {
						thisOption.find('td p').show();			
						thisOption.find('th').css('background-image', 'none');			
						thisOption.find('th').css('cursor', 'default');			
					}
					else{
						thisOption.find('td p').hide();
						thisOption.find('th').css('background-image', 'url(../wp-content/plugins/order-tracking/images/options-asset-info.png)');			
						thisOption.find('th').css('background-position', '95% 20px');			
						thisOption.find('th').css('background-size', '18px 18px');			
						thisOption.find('th').css('background-repeat', 'no-repeat');			
						thisOption.find('th').css('cursor', 'pointer');								
					}		
				}
				else{
					thisOption.find('td p').hide();
					thisOption.find('th').css('background-image', 'url(../wp-content/plugins/order-tracking/images/options-asset-info.png)');			
					thisOption.find('th').css('background-position', 'calc(100% - 20px) 15px');			
					thisOption.find('th').css('background-size', '18px 18px');			
					thisOption.find('th').css('background-repeat', 'no-repeat');			
					thisOption.find('th').css('cursor', 'pointer');			
				}
			});
			$('.ewdOptionHasInfo').each(function(){
				var thisNonTableOption = $(this);
				if( $(window).width() < 783 ){
					if( thisNonTableOption.find('.ewd-otp-admin-hide-radios').length > 0 ) {
						thisNonTableOption.find('fieldset p').show();			
						thisNonTableOption.find('ewd-otp-admin-styling-subsection-label').css('background-image', 'none');			
						thisNonTableOption.find('ewd-otp-admin-styling-subsection-label').css('cursor', 'default');			
					}
					else{
						thisNonTableOption.find('fieldset p').hide();
						thisNonTableOption.find('ewd-otp-admin-styling-subsection-label').css('background-image', 'url(../wp-content/plugins/order-tracking/images/options-asset-info.png)');			
						thisNonTableOption.find('ewd-otp-admin-styling-subsection-label').css('background-position', 'calc(100% - 30px) 15px');			
						thisNonTableOption.find('ewd-otp-admin-styling-subsection-label').css('background-size', '18px 18px');			
						thisNonTableOption.find('ewd-otp-admin-styling-subsection-label').css('background-repeat', 'no-repeat');			
						thisNonTableOption.find('ewd-otp-admin-styling-subsection-label').css('cursor', 'pointer');								
					}		
				}
				else{
					thisNonTableOption.find('fieldset p').hide();
					thisNonTableOption.find('ewd-otp-admin-styling-subsection-label').css('background-image', 'url(../wp-content/plugins/order-tracking/images/options-asset-info.png)');			
					thisNonTableOption.find('ewd-otp-admin-styling-subsection-label').css('background-position', 'calc(100% - 30px) 15px');			
					thisNonTableOption.find('ewd-otp-admin-styling-subsection-label').css('background-size', '18px 18px');			
					thisNonTableOption.find('ewd-otp-admin-styling-subsection-label').css('background-repeat', 'no-repeat');			
					thisNonTableOption.find('ewd-otp-admin-styling-subsection-label').css('cursor', 'pointer');			
				}
			});
			$('.toplevel_page_EWD-OTP-options #Emails .form-table tr').each(function(){
				var thisEmailsPageOption = $(this);
				if( $(window).width() < 783 ){
					thisEmailsPageOption.find('td p').hide();
					thisEmailsPageOptionthisEmailsPageOption.find('th').css('background-image', 'url(../wp-content/plugins/order-tracking/images/options-asset-info.png)');			
					thisEmailsPageOption.find('th').css('background-position', '95% 20px');			
					thisEmailsPageOption.find('th').css('background-size', '18px 18px');			
					thisEmailsPageOption.find('th').css('background-repeat', 'no-repeat');			
					thisEmailsPageOption.find('th').css('cursor', 'pointer');								
				}
				else{
					thisEmailsPageOption.find('td p').hide();
					thisEmailsPageOption.find('th').css('background-image', 'url(../wp-content/plugins/order-tracking/images/options-asset-info.png)');			
					thisEmailsPageOption.find('th').css('background-position', 'calc(100% - 20px) 15px');			
					thisEmailsPageOption.find('th').css('background-size', '18px 18px');			
					thisEmailsPageOption.find('th').css('background-repeat', 'no-repeat');			
					thisEmailsPageOption.find('th').css('cursor', 'pointer');			
				}
			});
		}).resize();
	});	
});


//OPTIONS PAGE YES/NO TOGGLE SWITCHES
jQuery(document).ready(function($) {
	jQuery('.ewd-otp-admin-option-toggle').on('change', function() {
		var Input_Name = jQuery(this).data('inputname'); console.log(Input_Name);
		if (jQuery(this).is(':checked')) {
			jQuery('input[name="' + Input_Name + '"][value="Yes"]').prop('checked', true).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="No"]').prop('checked', false);
			jQuery('input[name="' + Input_Name + '"][value="Order_Email"]').prop('checked', true).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="None"]').prop('checked', false);
		}
		else {
			jQuery('input[name="' + Input_Name + '"][value="Yes"]').prop('checked', false).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="No"]').prop('checked', true);
			jQuery('input[name="' + Input_Name + '"][value="Order_Email"]').prop('checked', false).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="None"]').prop('checked', true);
		}
	});
	$(function(){
		$(window).resize(function(){
			$('.otp-option-set .form-table tr').each(function(){
				var thisOptionTr = $(this);
				if( $(window).width() < 783 ){
					if( thisOptionTr.find('.ewd-otp-admin-switch').length > 0 ) {
						thisOptionTr.find('th').css('width', 'calc(90% - 50px');			
						thisOptionTr.find('th').css('padding-right', 'calc(5% + 50px');			
					}
					else{
						thisOptionTr.find('th').css('width', '90%');			
						thisOptionTr.find('th').css('padding-right', '5%');			
					}		
				}
				else{
					thisOptionTr.find('th').css('width', '200px');			
					thisOptionTr.find('th').css('padding-right', '46px');			
				}
			});
		}).resize();
	});	
});


/*************************************************************************
CONDITIONAL OPTIONS
**************************************************************************/
jQuery(document).ready(function($){
	$('input[data-inputname="woocommerce_integration"]').click(function(){
		if($(this).attr('checked') == 'checked'){
			$('.ewd-otp-admin-conditional-wc-options').show();
		}
		else{
			$('.ewd-otp-admin-conditional-wc-options').hide();
		}
	});
});


/*************************************************************************
NEW ORDERS TAB FORMATTING
**************************************************************************/
jQuery(document).ready(function($){
	$('#ewd-otp-admin-add-by-spreadsheet-button').click(function(){
		$('.toplevel_page_EWD-OTP-options #Orders #col-right').removeClass('ewd-otp-admin-products-table-full');
		$('.toplevel_page_EWD-OTP-options #Orders #col-left').removeClass('otp-hidden');
		$('#ewd-otp-admin-add-manually').addClass('otp-hidden');
		$('#ewd-otp-admin-add-from-spreadsheet').removeClass('otp-hidden');
	});
});


/*************************************************************************
CREATE/EDIT ORDER WIDGET TOGGLING
**************************************************************************/
jQuery(document).ready(function($){
	$('.ewd-otp-admin-closeable-widget-box').each(function(){
		var thisClosableWidgetBox = $(this);
		thisClosableWidgetBox.find('.ewd-otp-dashboard-new-widget-box-top').click(function(){
			thisClosableWidgetBox.find('.ewd-otp-dashboard-new-widget-box-bottom').toggle();
			thisClosableWidgetBox.find('.ewd-otp-admin-edit-product-down-caret').toggle();
			thisClosableWidgetBox.find('.ewd-otp-admin-edit-product-up-caret').toggle();
		});
	});
});


/*************************************************************************
* EMAILS TAB UWPM BANNER
**************************************************************************/
jQuery(document).ready(function($) {
	jQuery('.ewd-otp-uwpm-banner-remove').on('click', function() {
		jQuery('.ewd-otp-uwpm-banner').addClass('otp-hidden');
	
		var data = 'hide_length=999&action=ewd_otp_hide_uwpm_banner';
		jQuery.post(ajaxurl, data, function(response) {});
	});
	jQuery('.ewd-otp-uwpm-banner-reminder').on('click', function() {
		jQuery('.ewd-otp-uwpm-banner').addClass('otp-hidden');
	
		var data = 'hide_length=7&action=ewd_otp_hide_uwpm_banner';
		jQuery.post(ajaxurl, data, function(response) {});
	});
});

/*************************************************************************
* STATUS AND LOCATION EDITS SAVING
*************************************************************************/
jQuery(document).ready(function($) {
	jQuery('.ewd-otp-edit-status-input').on('keyup', function() {
		var statuses = [];
		jQuery('.edit-status-item').each(function(index, el) {
			var status = jQuery(this).find('[name="status[]"]').val();
			var percentage = jQuery(this).find('[name="status_percentages[]"]').val();
			var email = jQuery(this).find('[name="status_messages[]"]').val();
			var internal = jQuery(this).find('[name="status_internals[]"]').val();
	
			statuses.push({'status': status, 'percentage': percentage, 'email': email, 'internal': internal});
		});
	
		var data = 'status_data=' + JSON.stringify(statuses) + '&action=ewd_otp_update_statuses';
		jQuery.post(ajaxurl, data, function(response) {});
	});
	jQuery('.ewd-otp-statuses-select').on('change', function() {
		var statuses = [];
		jQuery('.edit-status-item').each(function(index, el) {
			var status = jQuery(this).find('[name="status[]"]').val();
			var percentage = jQuery(this).find('[name="status_percentages[]"]').val();
			var email = jQuery(this).find('[name="status_messages[]"]').val();
			var internal = jQuery(this).find('[name="status_internals[]"]').val();
	
			statuses.push({'status': status, 'percentage': percentage, 'email': email, 'internal': internal});
		});
	
		var data = 'status_data=' + JSON.stringify(statuses) + '&action=ewd_otp_update_statuses';
		jQuery.post(ajaxurl, data, function(response) {});
	});

	jQuery('.ewd-otp-edit-location-input').on('keyup', function() {
		
		var locations = [];
		jQuery('.edit-location-item').each(function(index, el) {
			var location = jQuery(this).find('[name="location[]"]').val();
			var location_latitude = jQuery(this).find('[name="location_latitude[]"]').val();
			var location_longitude = jQuery(this).find('[name="location_longitude[]"]').val();

			locations.push({'location': location, 'location_latitude': location_latitude, 'location_longitude': location_longitude});
		});

		var data = 'location_data=' + JSON.stringify(locations) + '&action=ewd_otp_update_locations';
		jQuery.post(ajaxurl, data, function(response) {});
	})
});