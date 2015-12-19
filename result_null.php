<!--#####################################################################
    #
    #   File          : ACTIVE FAILED
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
	include('includes/backend/mysqli_connect.php');
	include('includes/functions.php');
    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
    }else {
        redirect_to();
    }
 	include('includes/frontend/header.php');
?>
    <div class="four">
		<div class="container">
            <h3><?= $lang['FRONT_RESULT']?> : <?= $keyword?></h3>
			<p><?= $lang['FRONT_NO_RESULT']?></p>
        	<br>
			<a href="javascript:history.go(-1)" class="more">Go Back </a>
		</div>
	</div>
<?php include('includes/frontend/footer.php'); ?>

