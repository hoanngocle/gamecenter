<?php
    $title_page = 'Home';
    include('../includes/functions.php');
	include('../includes/backend/header-admin.php');
	include('../includes/backend/mysqli_connect.php');
    include('../includes/errors.php');
?>
	<!-- HEADER ####################################################################################### -->
	<div class="content-wrapper">
	    <div class="container">
<!-- 	    <div class="row">
	            <div class="col-md-12">
	                <h4 class="page-head-line">Dashboard</h4>
	            </div>
	        </div>
 -->
	        <div class="row">
	            <div class="col-md-12">
	                <h4 class="page-head-line"> Website Manager </h4>
	            </div>
	        </div>

	        <div class="row">
	        	<!-- News Manager ###################### -->
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-one">
                        <a href="list_news.php"><i  class="fa fa-newspaper-o dashboard-div-icon" ></i></a>
                         <h5>News Manager </h5>
                    </div>
                </div>

				<!-- Games Manager ###################### -->
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-two">
                        <a href="list_games.php"><i  class="fa fa-gamepad dashboard-div-icon" ></i></a>
                         <h5>Games Manager  </h5>
                    </div>
                </div>

				<!-- Gallery Manager ###################### -->
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-three">
                        <a href="list_images.php"><i  class="fa fa-picture-o dashboard-div-icon" ></i></a>
                        <h5>Gallery Manager  </h5>
                    </div>
                </div>

				<!-- Videos Manager ###################### -->
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-four">
                        <a href="list_videos.php"><i  class="fa fa-youtube-play dashboard-div-icon" ></i></a>
                         <h5>Videos Manager  </h5>
                    </div>
                </div>
		    </div>

			<div class="row">
	            <div class="col-md-12">
	                <h4 class="page-head-line"> Notice </h4>
	            </div>
	        </div>

	        <div class="row">
	            <div class="col-md-12">
	                <div class="alert alert-success">
	                 	Halo 3 is coming to PC. Eight years after Master Chief’s last great multiplayer playground hit the Xbox 360, it’s coming alive, for free, on the PC—but not at the hands of Microsoft. Or Bungie. In one of the strangest things to happen on PC this year, Halo 3’s protracted PC birth is coming from a group of modders transforming the free-to-play, Russia-only beta Halo Online into their favorite Halo game.
	                </div>
					<div class="alert alert-warning">
						For years, Halo was a crucial console-exclusive system-seller for Microsoft. When it finally came to the PC again earlier this spring but was region-locked, fans moved fast. They created Eldorito, a mod that cracked the Russia-only restriction within a week of Halo Online’s reveal. Named as a portmanteau of El Dorado, the name of the Halo Online executable, and Dorito, Microsoft’s favorite corporate sponsor, Eldorito has been programmed over the past few months by a group of between ten and twenty modders. Because Halo Online is built over the top of a more-or-less complete version of Halo 3’s engine, the Eldorito modders have been working to pull what they really want from the shell of Halo Online: Halo 3 on PC. I spent a week chatting with one of the modders to learn more about a project that, for better or worse, is the only version of Halo we’re likely to get on PC any time soon.  
					</div>
					<div class="alert alert-info">
						For years, Halo was a crucial console-exclusive system-seller for Microsoft. When it finally came to the PC again earlier this spring but was region-locked, fans moved fast. They created Eldorito, a mod that cracked the Russia-only restriction within a week of Halo Online’s reveal. Named as a portmanteau of El Dorado, the name of the Halo Online executable, and Dorito, Microsoft’s favorite corporate sponsor, Eldorito has been programmed over the past few months by a group of between ten and twenty modders. Because Halo Online is built over the top of a more-or-less complete version of Halo 3’s engine, the Eldorito modders have been working to pull what they really want from the shell of Halo Online: Halo 3 on PC. I spent a week chatting with one of the modders to learn more about a project that, for better or worse, is the only version of Halo we’re likely to get on PC any time soon.  
					</div>
	            </div>
	        </div>
		</div>
	</div>
	<!-- FOOTER ####################################################################################### -->
<?php include('../includes/backend/footer-admin.php'); ?>