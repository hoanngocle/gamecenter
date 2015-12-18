<!--#####################################################################
    #
    #   File          : CHANGE STATUS VIDEO
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    include('../includes/functions.php');
	include('../includes/backend/mysqli_connect.php');

    if(isset($_GET)){
        $iid = validate_id($_GET['iid']);
        $stt = validate_id($_GET['stt']);
		// Change status
		$result = change_status_image($iid, $stt);
		if(mysqli_affected_rows($dbc) == 1 ) {
			redirect_to('admin/list_images.php');
		}else {
			redirect_to('admin/list_images.php');
		}
    }
