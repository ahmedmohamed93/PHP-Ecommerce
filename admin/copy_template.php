<?php
/*
   ====================================================
   ** Manage ......... Page
   ** you can Add | Edit | Delete ....... Form Here
   ====================================================
*/
ob_start();  // Output Buffering Start

session_start();
$pageTitle = '';

if (isset($_SESSION['us'])) {
	include 'init.php';
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		
	if ($do == 'Manage') { // Manage Members Page

	    
	}elseif ($do == 'Add') { // Add Page 

			
	} elseif ($do == 'Insert') {// Insert Member Page
			

	} elseif ($do == 'Edit') { //Edit Page

			
	}elseif ($do == 'Update') { // Update Page
			
	
	}elseif ($do == 'Delete') { // Delete Member Page

			
	}elseif($do == 'Activate'){ // Activate Page

		    
	}else{
		
	}

	include $templ.'footer.php';

}else {
		header('Location: index.php');
		exit();
}
ob_end_flush();  // Release The Output
?>