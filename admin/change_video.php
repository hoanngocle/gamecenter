<!-- 
    File       : change_video.php
    Created on : Jul 11, 2015, 10:26:53 AM
    Updated on : Nov 11, 2015, 10:26:53 AM   
    Author     : Béo
-->
<?php 
    include('../includes/functions.php');
	include('../includes/backend/mysqli_connect.php');
    
    if(isset($_GET)){
        $vid = validate_id($_GET['vid']);
        $stt = validate_id($_GET['stt']);
		// Change status
		$result = change_status_video($vid, $stt);
		if(mysqli_affected_rows($dbc) == 1 ) {			
			redirect_to('admin/list_videos.php');
		}else {
			redirect_to('admin/list_videos.php');	
		}
    }
