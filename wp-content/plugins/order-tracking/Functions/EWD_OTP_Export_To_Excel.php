<?php
if (!class_exists('ComposerAutoloaderInit4618f5c41cf5e27cc7908556f031e4d4')) {require_once EWD_OTP_CD_PLUGIN_PATH . 'PHPSpreadsheet/vendor/autoload.php';}
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
function EWD_OTP_Export_To_Excel() {
		global $wpdb;
		global $EWD_OTP_orders_table_name;
		global $EWD_OTP_customers;
		global $EWD_OTP_sales_reps;
		global $EWD_OTP_fields_table_name;
		global $EWD_OTP_fields_meta_table_name;

		$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");

		if (isset($_GET['Format_Type'])) {$Format_Type = sanitize_text_field( $_GET['Format_Type'] );}
		if (isset($_GET['Sales_Rep_ID'])) {$Sales_Rep_ID = intval( $_GET['Sales_Rep_ID'] );}
		if (isset($_GET['Sales_Rep_Email'])) {$Sales_Rep_Email = sanitize_email( $_GET['Sales_Rep_Email'] );}
		if (isset($_GET['Customer_ID'])) {$Customer_ID = intval( $_GET['Customer_ID'] );}
		if (isset($_GET['Customer_Email'])) {$Customer_Email = sanitize_email( $_GET['Customer_Email'] );}

		if (isset($_GET['Sales_Rep_ID']) or isset($_GET['Customer_ID'])) {$Front_End_Download = true;}
		else {$Front_End_Download = false;}

		if ($Email_Confirmation == "Order_Email" and (isset($Customer_ID) or isset($Sales_Rep_ID))) {
			if (isset($Customer_ID)) {
				$Sql = "SELECT Customer_ID FROM $EWD_OTP_customers WHERE Customer_ID=%d AND Customer_Email=%s"; 
				$Arguments = array($Customer_ID, $Customer_Email);
			}
			if (isset($Sales_Rep_ID)) {
				$Sql = "SELECT Sales_Rep_ID FROM $EWD_OTP_sales_reps WHERE Sales_Rep_ID=%d AND Sales_Rep_Email=%s"; 
				$Arguments = array($Sales_Rep_ID, $Sales_Rep_Email);
			}

			$wpdb->get_results($wpdb->prepare($Sql, $Arguments));
			if ($wpdb->num_rows == 0) {return;}
		}

		if (!isset($Customer_ID) and !isset($Sales_Rep_ID) and !is_admin()) {return;}

		$Customers_Exist = $wpdb->get_var("SELECT COUNT(Customer_ID) FROM $EWD_OTP_customers");
		$Sales_Reps_Exist = $wpdb->get_var("SELECT COUNT(Sales_Rep_ID) FROM $EWD_OTP_sales_reps");
		
		// Instantiate a new PHPExcel object 
		$Spreadsheet = new Spreadsheet();  
		// Set the active Excel worksheet to sheet 0 
		$Spreadsheet->setActiveSheetIndex(0);  

		// Print out the regular order field labels
		$Spreadsheet->getActiveSheet()->setCellValue("A1", "Name");
		$Spreadsheet->getActiveSheet()->setCellValue("B1", "Number");
		$Spreadsheet->getActiveSheet()->setCellValue("C1", "Order Status");
		$Spreadsheet->getActiveSheet()->setCellValue("D1", "Order Status Updated (Read-Only)");
		$Spreadsheet->getActiveSheet()->setCellValue("E1", "Display");
		$Spreadsheet->getActiveSheet()->setCellValue("F1", "Notes Public");
		$Spreadsheet->getActiveSheet()->setCellValue("G1", "Notes Private");
		$Spreadsheet->getActiveSheet()->setCellValue("H1", "Email");

		$column = 'I';

		if ($Customers_Exist) {
			$Spreadsheet->getActiveSheet()->setCellValue($column."1", "Customer ID");
			$column++;
		}

		if ($Sales_Reps_Exist) {
			$Spreadsheet->getActiveSheet()->setCellValue($column."1", "Sales Rep ID");
			$column++;
		}

		//start of printing column names as names of custom fields  
		$Sql = "SELECT * FROM $EWD_OTP_fields_table_name";
		$Custom_Fields = $wpdb->get_results($Sql);
		foreach ($Custom_Fields as $Custom_Field) {
     		$Spreadsheet->getActiveSheet()->setCellValue($column."1", $Custom_Field->Field_Name);
    		$column++;
		}  

		//start while loop to get data  
		$rowCount = 2;  
		$Sql = "SELECT * FROM $EWD_OTP_orders_table_name WHERE 1=%d ";
		$Arguments = array(1);
		if (isset($Customer_ID)) {$Sql .= "AND Customer_ID=%d "; $Arguments[] = $Customer_ID;}
		if (isset($Sales_Rep_ID)) {$Sql .= "AND Sales_Rep_ID=%d "; $Arguments[] = $Sales_Rep_ID;}
		$Orders = $wpdb->get_results($wpdb->prepare($Sql, $Arguments));
		foreach ($Orders as $Order)  
		{  
    	 	$Spreadsheet->getActiveSheet()->setCellValue("A" . $rowCount, $Order->Order_Name);
			$Spreadsheet->getActiveSheet()->setCellValue("B" . $rowCount, $Order->Order_Number);
			$Spreadsheet->getActiveSheet()->setCellValue("C" . $rowCount, $Order->Order_Status);
			$Spreadsheet->getActiveSheet()->setCellValue("D" . $rowCount, $Order->Order_Status_Updated);
			$Spreadsheet->getActiveSheet()->setCellValue("E" . $rowCount, $Order->Order_Display);
			$Spreadsheet->getActiveSheet()->setCellValue("F" . $rowCount, $Order->Order_Notes_Public);
			$Spreadsheet->getActiveSheet()->setCellValue("G" . $rowCount, $Order->Order_Notes_Private);
			$Spreadsheet->getActiveSheet()->setCellValue("H" . $rowCount, $Order->Order_Email);
				
			$column = 'I';

			if ($Customers_Exist) {
				$Spreadsheet->getActiveSheet()->setCellValue($column.$rowCount, $Order->Customer_ID);
				$column++;
			}

			if ($Sales_Reps_Exist) {
				$Spreadsheet->getActiveSheet()->setCellValue($column.$rowCount, $Order->Sales_Rep_ID);
				$column++;
			}

    		foreach ($Custom_Fields as $Custom_Field) {  
        		$MetaValue = $wpdb->get_var($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order->Order_ID, $Custom_Field->Field_ID));

        		$Spreadsheet->getActiveSheet()->setCellValue($column.$rowCount, $MetaValue);
        		$column++;
    		}

    		$rowCount++;
		} 

		if ($Front_End_Download) {$Spreadsheet->getActiveSheet()->removeColumn('G');}

		// Redirect output to a client’s web browser (Excel5) 
		if (isset($Format_Type) and $Format_Type == "CSV") {
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="Order_Export.csv"'); 
			header('Cache-Control: max-age=0'); 
			$objWriter = new Csv($Spreadsheet);
			$objWriter->save('php://output');
		}
		else {
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="Order_Export.xls"'); 
			header('Cache-Control: max-age=0'); 
			$objWriter = new Xls($Spreadsheet);
			$objWriter->save('php://output');
		}

		exit();
}
?>