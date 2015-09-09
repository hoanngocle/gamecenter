<?php
	//Include file php function vs connect DB
	include('includes/backend/mysqli_connect.php'); 
	include('includes/functions.php');
 	include('includes/frontend/header.php');
 	include('includes/frontend/banner.php');
?>
<!--content-->
	<div class="content">
		<div class="container">
			<div class="content-top">
				<h2 class="new">NEW GAMES</h2>
				<div class="wrap">	
					<div class="main">
						<ul id="og-grid" class="og-grid">
						<li>
							<a href="#" data-largesrc="images/1.jpg" data-title="Subway Surfers" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque malesuada purus a convallis dictum. Phasellus sodales varius diam, non sagittis lectus. Morbi id magna ultricies ipsum condimentum scelerisque vel quis felis.. Donec et purus nec leo interdum sodales nec sit amet magna. Ut nec suscipit purus, quis viverra urna.">
								<img class="img-responsive" src="images/thumbs/1.jpg" alt="img01"/>
							</a>
						</li>
						<li>
							<a href="#" data-largesrc="images/2.jpg" data-title="Angry Birds" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque malesuada purus a convallis dictum. Phasellus sodales varius diam, non sagittis lectus. Morbi id magna ultricies ipsum condimentum scelerisque vel quis felis.. Donec et purus nec leo interdum sodales nec sit amet magna. Ut nec suscipit purus, quis viverra urna.">
								<img class="img-responsive" src="images/thumbs/2.jpg" alt="img02"/>
							</a>
						</li>
						<li>
							<a href="#" data-largesrc="images/3.jpg" data-title="Bike Games"  data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque malesuada purus a convallis dictum. Phasellus sodales varius diam, non sagittis lectus. Morbi id magna ultricies ipsum condimentum scelerisque vel quis felis.. Donec et purus nec leo interdum sodales nec sit amet magna. Ut nec suscipit purus, quis viverra urna.">
								<img class="img-responsive" src="images/thumbs/3.jpg" alt="img03"/>
							</a>
						</li>
						<li>
							<a href="#" data-largesrc="images/4.jpg" data-title="Temple Run"  data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque malesuada purus a convallis dictum. Phasellus sodales varius diam, non sagittis lectus. Morbi id magna ultricies ipsum condimentum scelerisque vel quis felis.. Donec et purus nec leo interdum sodales nec sit amet magna. Ut nec suscipit purus, quis viverra urna.">
								<img class="img-responsive" src="images/thumbs/4.jpg" alt="img01"/>
							</a>
						</li>
						<li>
							<a href="#" data-largesrc="images/5.jpg" data-title="Car Games"  data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque malesuada purus a convallis dictum. Phasellus sodales varius diam, non sagittis lectus. Morbi id magna ultricies ipsum condimentum scelerisque vel quis felis.. Donec et purus nec leo interdum sodales nec sit amet magna. Ut nec suscipit purus, quis viverra urna.">
								<img class="img-responsive" src="images/thumbs/5.jpg" alt="img01"/>
							</a>
						</li>
						<li>
							<a href="#" data-largesrc="images/6.jpg" data-title="Fite Games"  data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque malesuada purus a convallis dictum. Phasellus sodales varius diam, non sagittis lectus. Morbi id magna ultricies ipsum condimentum scelerisque vel quis felis.. Donec et purus nec leo interdum sodales nec sit amet magna. Ut nec suscipit purus, quis viverra urna.">
								<img class="img-responsive" src="images/thumbs/6.jpg" alt="img02"/>
							</a>
						</li>
						<li>
							<a href="#" data-largesrc="images/7.jpg" data-title="Fite Games"  data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque malesuada purus a convallis dictum. Phasellus sodales varius diam, non sagittis lectus. Morbi id magna ultricies ipsum condimentum scelerisque vel quis felis.. Donec et purus nec leo interdum sodales nec sit amet magna. Ut nec suscipit purus, quis viverra urna.">
								<img class="img-responsive" src="images/thumbs/7.jpg" alt="img03"/>
							</a>
						</li>
						<li>
							<a href="#" data-largesrc="images/8.jpg" data-title="Panda Game" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque malesuada purus a convallis dictum. Phasellus sodales varius diam, non sagittis lectus. Morbi id magna ultricies ipsum condimentum scelerisque vel quis felis.. Donec et purus nec leo interdum sodales nec sit amet magna. Ut nec suscipit purus, quis viverra urna.">
								<img class="img-responsive" src="images/thumbs/8.jpg" alt="img01"/>
							</a>
						</li>
						 <div class="clearfix"> </div>
						</ul>
					</div>
				</div>
			</div>
			<script src="js/grid.js"></script>
			<script>
				$(function() {
					Grid.init();
				});
			</script>
		</div>

		<!----->
			<div class="col-mn">
				<div class="container">
						<div class="col-mn2">
							<h3>The Best Features</h3>
							<p>Contrary to popular belief
								, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
							<a class=" more-in" href="single.html">Read More</a>
					</div>
				</div>
			</div>
			<!---->
		<!--  ###################################################################################### -->
			<div class="featured">
				<div class="container">
					<!-- Lastest News #################################### -->
					<div class="col-md-4 latest">						
						<h4>Latest</h4>
						<?php 
							$result = get_lastest_news();
							if (mysqli_num_rows($result) > 0 ) {
								// Neu co post de hien thi thi in ra
								while ($lastest_news = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
									echo "
										<div class='late'>
											<a href='single.php?nid={$lastest_news['news_id']}' class='fashion'><img class='img-responsive' src='images/{$lastest_news['avatar']}' alt='{$lastest_news['avatar']}'></a>
											<div class='grid-product'>
												<span>{$lastest_news['date']}</span>
												<p><a href='single.php?nid={$lastest_news['news_id']}' >{$lastest_news['title']}</a></p>
												<a class='comment' href='single.php?nid={$lastest_news['news_id']}'><i> </i>{$lastest_news['count']} Comments</a>
											</div>
										<div class='clearfix'> </div>
										</div>
									";
								}		
							}
						 ?>
					</div>

					<!-- Featured News #################################### -->
					<div class="col-md-4 latest">
						<h4>Hotest</h4>
						<?php 
							$result = get_hot_news();
							if (mysqli_num_rows($result) > 0 ) {
								// Neu co post de hien thi thi in ra
								while ($lastest_news = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
									echo "
										<div class='late'>
											<a href='single.php' class='fashion'><img class='img-responsive' src='images/{$lastest_news['avatar']}' alt='{$lastest_news['avatar']}'></a>
											<div class='grid-product'>
												<span>{$lastest_news['date']}</span>
												<p><a href='single.php?nid=''' >{$lastest_news['title']}</a></p>
												<a class='comment' href='single.php'><i> </i>{$lastest_news['count']} Comments</a>
											</div>
										<div class='clearfix'> </div>
										</div>
									";
								}		
							}
						 ?>
					</div>

					<!-- Popular News #################################### -->
					<div class="col-md-4 latest">
						<h4>Popular</h4>
						<?php 
							$result = get_popular_news();
							if (mysqli_num_rows($result) > 0 ) {
								// Neu co post de hien thi thi in ra
								while ($lastest_news = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
									echo "
										<div class='late'>
											<a href='single.php' class='fashion'><img class='img-responsive' src='images/{$lastest_news['avatar']}' alt='{$lastest_news['avatar']}'></a>
											<div class='grid-product'>
												<span>{$lastest_news['date']}</span>
												<p><a href='single.php' >{$lastest_news['title']}</a></p>
												<a class='comment' href='single.php'><i> </i>{$lastest_news['count']} Comments</a>
											</div>
										<div class='clearfix'> </div>
										</div>
									";
								}				
							}
						 ?>
					</div>

					<!-- End of News #################################### -->

					<div class="clearfix"> </div>
					<br><br>

					<h2 class="new">GALLERY</h2>
					<div>
						


					</div>

					<!-- End of Gallery #################################### -->
					<h2 class="new">VIDEOS</h2>
<div>
	<div class="">
		
	</div>
</div>

					<!-- End of Videos  #################################### -->

				</div>
			</div>
		
	<!-- goi file chua footer -->
<?php include('includes/frontend/footer.php'); ?>