<?php
	//Include file php function vs connect DB
	include('includes/backend/mysqli_connect.php'); 
	include('includes/functions.php');
 	include('includes/frontend/header.php');
    
?>
    <div class="four">
		<div class="container">	
            <h2>Congratulation!</h2>
			<p>Bạn đã đăng kí thành công tài khoản ở GameCenter. <br> Vui lòng vào email để kích hoạt tài khoản.</p>	
            <br>
			
			<a href="javascript:history.go(-1)" class="more">Go Back </a>
		</div>
	</div>


<!---->
<?php include('includes/frontend/footer.php'); ?>	