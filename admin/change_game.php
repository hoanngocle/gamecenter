<!--#####################################################################
    #
    #   File          : CHANGE STATUS NEW
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    include('../includes/functions.php');
	include('../includes/backend/mysqli_connect.php');

    if(isset($_GET)){
        $nid = validate_id($_GET['nid']);
        $stt = validate_id($_GET['stt']);
		// Change status
		$result = change_status_news($nid, $stt);
		if(mysqli_affected_rows($dbc) == 1 ) {
			redirect_to('admin/list_games.php');
		}else {
			redirect_to('admin/list_games.php');
		}
    }
