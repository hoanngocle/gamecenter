<?php 
    include('../includes/functions.php');
	include('../includes/backend/mysqli_connect.php');
    
    if(isset($_GET)){
        $uid = validate_id($_GET['uid']);
        $stt = validate_id($_GET['stt']);
		// Change status
		$result = change_status_user($uid, $stt);
		if(mysqli_affected_rows($dbc) == 1 ) {			
			redirect_to('admin/list_user.php');
		}else {
			redirect_to('admin/list_user.php');	
		}
    }
