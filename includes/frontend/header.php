<!--#####################################################################
    #
    #   File          : Header - Header index in website  
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #   Last Change   : 10/14/2015
    #
    ##################################################################### -->
<?php 
    session_start();
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > (60*60))) {
        // last login was more than 15 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        redirect_to('index.php');
    }
    if(isset($_SESSION['uid'])){
        $rsuser= get_user_by_id($_SESSION['uid']);
        $user = array();
        if(mysqli_num_rows($rsuser) == 1){
            $user = mysqli_fetch_array($rsuser, MYSQLI_ASSOC);
        }
    }
    
    ?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo (isset($title)) ? $title : "Game Center" ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="http://s16.postimg.org/9irj2l7n5/gamemagazine.png">    
        
        <!-- JavaScript -->
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<script src="js/modernizr.custom.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="/includes/video-js/video.js"></script>
        <script src="/includes/video-js/media.youtube.js"></script>
        <script src="/js/jquery.leanModal.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        
        <link href="css/login_modal.css" rel="stylesheet" type="text/css"/>
        <link href="/includes/video-js/video-js.css" rel="stylesheet" type="text/css">        
		<link href="css/component.css" rel="stylesheet" type="text/css" />
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" id="bootstrap-css" />	
		<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />	

	</head>

	<body> 
	<div class="header" >
		<div class="top-header" >		
			<div class="container">
				<div class="top-head" >	
					<ul class="header-in">
						<li><a href="help.php" >  Help</a></li>
						<li><a href="contact_us.php">   Contact Us</a></li>
						<li><a href="how_to_use.php" >   How To Use</a></li>
					</ul>
                    <div class="search">
                        <?php 


                        ?>
                        <form action="" method="post">
                            <input type="text" id="search" name="search" value="<?php ?>" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'search about something ?';}" >
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
						<h1><a href="index.php"><span> G</span>ames <span>M</span>agazine</a></h1>
					</div>
					<div class="top-nav">		
					  	<span class="menu"><img src="images/menu.png" alt=""> </span>
						<ul>
							<li><a class="color1" href="index.php"  >Home</a></li>
							<li><a class="color2" href="news.php"  >News</a></li>
                            <li><a class="color5" href="games.php"  >Games</a></li>
							<li><a class="color3" href="gallery.php"  >Gallery</a></li>
							<li><a class="color4" href="video.php" >Video</a></li>
							<li><a class="color6" href="contact_us.php" >Contact Us</a></li>
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
	