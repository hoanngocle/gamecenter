<!--#####################################################################
    #
    #   File          : DELETE VIDEO
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
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
					alert('{$lang['AD_DEL_SUCCESS']}');
                    window.location = 'list_videos.php';
				</script>
			";
		}else {
			echo "
				<script type='text/javascript'>
					alert('{$lang['AD_DEL_FAIL']}');
                    window.location = 'list_videos.php';
				</script>
			";
		}
