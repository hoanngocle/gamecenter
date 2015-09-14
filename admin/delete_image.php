<?php 
	include('../includes/backend/mysqli_connect.php');
	include('../includes/functions.php'); 
    
	$iid = validate_id($_GET['iid']);
		// Neu muon delete page
		$result = delete_images($iid);
		if(mysqli_affected_rows($dbc) == 1 ) {	
			echo "
				<script type='text/javascript'>
					delete_success();
				</script>      
			";
			redirect_to('admin/view_images.php');
		}else {
			echo "
				<script type='text/javascript'>
					delete_fail();
				</script>      
			";
			redirect_to('admin/index.php');	
		}
