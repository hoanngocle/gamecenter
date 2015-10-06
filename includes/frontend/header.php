<?php session_start(); ?>
<!DOCTYPE html>
<!--
	Project Name: Game Center
	Author: Béo Sagittarius
	Author URI: http://www.facebook.com/beo.sagittarius.93/
	Date Create: 01/07/2015
-->
<html>
	<head>
		<title><?php echo (isset($title)) ? $title : "Game Center" ?></title>
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
		<script src="js/jquery.min.js"></script>
		<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />	
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

		<script src="js/modernizr.custom.js"></script>
		<link rel="stylesheet" type="text/css" href="css/component.css" />
        <link rel="stylesheet" type="text/css" href="../includes/slider/engine/style.css" />
        <script type="text/javascript" src="../includes/slider/engine/jquery.js"></script>
	</head>
	<!-- End of script -->
	<body> 


	<div class="header" >
		<div class="top-header" >		
			<div class="container">
				<div class="top-head" >	
					<ul class="header-in">
						<li ><a href="#" >  Help</a></li>
						<li><a href="contact.html">   Contact Us</a></li>
						<li ><a href="#" >   How To Use</a></li>
					</ul>
						<div class="search">
							<form>
								<input type="text" value="search about something ?" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'search about something ?';}" >
								<input type="submit" value="" >
							</form>
						</div>
						<div class="clearfix"> </div>
				</div>
			</div>
		</div>
			<!--END of top header //  -->
		
		<div class="header-top">
			<div class="container">
				<div class="head-top">
					<div class="logo">
						<h1><a href="index.php"><span> G</span>ames <span>C</span>enter</a></h1>
					</div>
					<div class="top-nav">		
					  	<span class="menu"><img src="images/menu.png" alt=""> </span>
						<ul>
							<li><a class="color1" href="index.php"  >Home</a></li>
							<li><a class="color2" href="news.php"  >News</a></li>
							<li><a class="color3" href="gallery.php"  >Gallery</a></li>
							<li><a class="color4" href="video.php" >Video</a></li>
							<li><a class="color5" href="contact_us.php"  >Contact Us</a></li>
							<li><a class="color6" href="register.php" >Register</a></li>
							<div class="clearfix"> </div>
						</ul>
							<!--script-->
						<script>
							$("span.menu").click(function(){
								$(".top-nav ul").slideToggle(500, function(){
								});
							});
						</script>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
		</div>
		<!--END of top header // menu navigation -->
	</div>
	