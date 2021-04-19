(function() {
    tinymce.PluginManager.add('OTP_Shortcodes', function( editor, url ) {
        //editor.on('init', function(args){EWD_OTP_Disable_Non_Premium();});
        editor.addButton( 'OTP_Shortcodes', {
            title: 'OTP Shortcodes',
            text: 'Tracking',
            type: 'menubutton',
            icon: 'wp_code',
            menu: [{
            	text: 'Tracking Form',
            	value: 'tracking-form',
            	onclick: function() {
				    var win = editor.windowManager.open( {
				        title: 'Insert Status Tracking Shortcode',
				        body: [{
            				type: 'checkbox',
            				name: 'show_orders',
            				label: 'Show all orders on pageload:'
				        }],
				        onsubmit: function( e ) {
				            if (e.data.show_orders) {var show_orders_text = "show_orders='Yes'";}
				            else {var show_orders_text = "";}

				            editor.insertContent( '[tracking-form '+show_orders_text+']');
				        }
				    });
				}
			},
			{
            	text: 'Customer Tracking',
            	onPostRender: function() {EWD_OTP_Customer_Tracking_Non_Premium();},
            	value: 'customer-form',
            	id: 'customer-form',
            	onclick: function() {
				    var premium = EWD_OTP_Is_Premium();
				    if (!premium) {return;}

				    editor.insertContent( '[customer-form]');
				}
			},
			{
            	text: 'Sales Rep Tracking',
            	onPostRender: function() {EWD_OTP_Sales_Rep_Tracking_Non_Premium();},
            	value: 'sales-rep-form',
            	id: 'sales-rep-form',
            	onclick: function() {
				    var premium = EWD_OTP_Is_Premium();
				    if (!premium) {return;}

				    editor.insertContent( '[sales-rep-form]');
				}
			},
			{
            	text: 'Customer Order Form',
            	onPostRender: function() {EWD_OTP_Customer_Order_Non_Premium();},
            	value: 'customer-order',
            	id: 'customer-order',
            	onclick: function() {
				    var premium = EWD_OTP_Is_Premium();
				    if (!premium) {return;}
				    
				    var win = editor.windowManager.open( {
				        title: 'Insert Customer Order Shortcode',
				        body: [{
            				type: 'listbox',
            				name: 'order_status',
            				label: 'Order status when submitted:',
				            'values': EWD_OTP_Create_Statuses_List()
				        },
				        {
            				type: 'listbox',
            				name: 'order_location',
            				label: 'Order location when submitted:',
				            'values': EWD_OTP_Create_Locations_List()
				        }],
				        onsubmit: function( e ) {
				            if (e.data.order_status != -1) {var order_status_text = "order_status='" + e.data.order_status + "'";}
				            else {var order_status_text = "";}
				            if (e.data.order_location != -1) {var order_location_text = "order_location='" + e.data.order_location + "'";}
				            else {var order_location_text = "";}

				            editor.insertContent( '[customer-order '+order_status_text+' '+order_location_text+']');
				        }
				    });
				}
			}],
        });
    });
})();

function EWD_OTP_Create_Statuses_List() {
	var result = [{text: 'None', value: '-1'}];
    var d = {};

	jQuery(order_statuses).each(function(index, el) {
		var d = {};
		console.log(el);
		d['text'] = el.Status;
		d['value'] = el.Status;
		//console.log(d);
		result.push(d)
		//console.log(result);
	});

    return result;
}

function EWD_OTP_Create_Locations_List() {
	var result = [{text: 'None', value: '-1'}];
    var d = {};

	jQuery(order_locations).each(function(index, el) {
		var d = {};
		console.log(el);
		d['text'] = el.Name;
		d['value'] = el.Name;
		//console.log(d);
		result.push(d)
		//console.log(result);
	});

    return result;
}

function EWD_OTP_Customer_Tracking_Non_Premium() {
	var premium = EWD_OTP_Is_Premium();

	if (!premium) {
		jQuery('#customer-form').css('opacity', '0.5');
		jQuery('#customer-form').css('cursor', 'default');
	}
}

function EWD_OTP_Sales_Rep_Tracking_Non_Premium() {
	var premium = EWD_OTP_Is_Premium();

	if (!premium) {
		jQuery('#sales-rep-form').css('opacity', '0.5');
		jQuery('#sales-rep-form').css('cursor', 'default');
	}
}

function EWD_OTP_Customer_Order_Non_Premium() {
	var premium = EWD_OTP_Is_Premium();

	if (!premium) {
		jQuery('#customer-order').css('opacity', '0.5');
		jQuery('#customer-order').css('cursor', 'default');
	}
}

function EWD_OTP_Is_Premium() {
	if (otp_premium == "Yes") {return true;}
	
	return false;
}
