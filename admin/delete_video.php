<?php 
    include('../includes/functions.php');
	include('../includes/backend/header-admin.php');
	include('../includes/backend/mysqli_connect.php');

	$vid = validate_id($_GET['vid']);
		// Neu muon delete page
		$result = delete_videos($vid);
		if(mysqli_affected_rows($dbc) == 1 ) {	
			echo "
				<script type='text/javascript'>
					delete_success();
				</script>      
			";
			redirect_to('admin/list_videos.php');
		}else {
			echo "
				<script type='text/javascript'>
					delete_fail();
				</script>      
			";
			redirect_to('admin/index.php');	
		}
