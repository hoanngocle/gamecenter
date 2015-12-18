<!--#####################################################################
    #
    #   File          : DELETE IMAGE
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    include('../includes/functions.php');
	include('../includes/backend/header-admin.php');
	include('../includes/backend/mysqli_connect.php');

	$iid = validate_id($_GET['iid']);
		// Neu muon delete page
		$result = delete_images($iid);
		if(mysqli_affected_rows($dbc) == 1 ) {
			echo "
				<script type='text/javascript'>
					alert('{$lang['AD_DEL_SUCCESS']}');
                    window.location = 'list_images.php';
				</script>
			";
		}else {
			echo "
				<script type='text/javascript'>
					alert('{$lang['AD_DEL_FAIL']}');
                    window.location = 'list_images.php';
				</script>
			";
		}
