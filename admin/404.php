<!--#####################################################################
    #
    #   File          : 404 ADMIN
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
	include('../includes/backend/mysqli_connect.php');
	include('../includes/functions.php');
 	include('../includes/backend/header-admin.php');
?>
<div class="four">
	<div class="container">
		<p>OOPS! - <?= $lang['404']?></p>
		<h2>404</h2>
		<a href="javascript:history.go(-1)" class="more">Go Back </a>
	</div>
</div>
<?php include('../includes/backend/footer-admin.php'); ?>