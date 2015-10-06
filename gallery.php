<!-- goi file chua header -->
<?php 
	//Include file php function vs connect DB
	include('includes/backend/mysqli_connect.php'); 
	include('includes/functions.php');
	
	include('includes/frontend/header.php');
    
?>

<!--content-->
<div class="container">
			<div class="games">
				<h2> Gallery</h2>
                <div id="wowslider-container1">
	<div class="ws_images"><ul>
		<li><img src="images/1.jpg" alt="1" title="1" id="wows1_0"/></li>
		<li><img src="images/2.jpg" alt="2" title="2" id="wows1_1"/></li>
		<li><img src="images/3.jpg" alt="3" title="3" id="wows1_2"/></li>
		<li><img src="images/4.jpg" alt="4" title="4" id="wows1_3"/></li>
		<li><img src="images/5.jpg" alt="5" title="5" id="wows1_4"/></li>
		<li><img src="images/6.jpg" alt="6" title="6" id="wows1_5"/></li>
		<li><a href="http://wowslider.com/vi"><img src="data1/images/7.jpg" alt="cssslider" title="7" id="wows1_6"/></a></li>
		<li><img src="data1/images/8.jpg" alt="8" title="8" id="wows1_7"/></li>
	</ul></div>
	<div class="ws_bullets"><div>
		<a href="#" title="1"><span><img style="width: 85px; height: 48px" src="images/1.jpg" alt="1"/>1</span></a>
		<a href="#" title="2"><span><img style="width: 120px; height: 120px;" src="images/2.jpg" alt="2"/>2</span></a>
		<a href="#" title="3"><span><img src="images/3.jpg" alt="3"/>3</span></a>
		<a href="#" title="4"><span><img src="images/4.jpg" alt="4"/>4</span></a>
		<a href="#" title="5"><span><img src="images/5.jpg" alt="5"/>5</span></a>
		<a href="#" title="6"><span><img src="images/6.jpg" alt="6"/>6</span></a>
		<a href="#" title="7"><span><img src="images/7.jpg" alt="7"/>7</span></a>
		<a href="#" title="8"><span><img src="images/8.jpg" alt="8"/>8</span></a>
	</div></div><div class="ws_script" style="position:absolute;left:-99%"><a href="http://wowslider.com">wow slider</a> by WOWSlider.com v8.5</div>
	<div class="ws_shadow"></div>
	</div>	
	<script type="text/javascript" src="../includes/slider/engine/wowslider.js"></script>
	<script type="text/javascript" src="../includes/slider/engine/script.js"></script>
            </div>
</div>

<!-- goi file chua header -->
<?php include('includes/frontend/footer.php'); ?>