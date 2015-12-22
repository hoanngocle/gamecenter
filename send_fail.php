<?php
    #####################################################################
    #
    #   File          : SEND FAIL
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    #####################################################################
	include('includes/backend/mysqli_connect.php');
	include('includes/functions.php');
 	include('includes/frontend/header.php');
?>
    <div class="four">
		<div class="container">
            <h3>SORRY!</h3>
			<p>Đã có lỗi xảy ra khi nhận thông tin góp ý của bạn <br> Vui lòng gửi lại nội dung vào hmf thư của chúng tôi.</p>
        	<br>
			<a href="javascript:history.go(-1)" class="more">Go Back </a>
		</div>
	</div>
<?php include('includes/frontend/footer.php'); ?>

