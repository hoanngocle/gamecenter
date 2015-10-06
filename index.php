<?php
	//Include file php function vs connect DB
	include('includes/backend/mysqli_connect.php'); 
	include('includes/functions.php');
 	include('includes/frontend/header.php');
 	include('includes/frontend/banner.php');
?>
	
	<div class="content">
        <!--===================================== New game [start] =====================================-->
		<div class="container">
			<div class="content-top">
				<h2 class="new">NEW GAMES</h2>
				<div class="wrap">	
					<div class="main">
						<ul id="og-grid" class="og-grid">
							<?php 
								$result= get_new_games();
								if(mysqli_num_rows($result) > 0){
									while($games = mysqli_fetch_array($result, MYSQLI_ASSOC)){
										$content = excerpt_features($games['content']);
							?>
							<li>
								<a href="single.php?nid=<?= $games['news_id'];  ?>" data-largesrc="images/<?= $games['image']; ?>" data-title="<?= $games['title']; ?>" data-description="<?= $content ?>...">
									<img class="img-responsive" src="images/<?= $games['image']; ?>" alt="img<?= $games['image']; ?>"/>
								</a>
							</li>
							<?php 
								}
							}
							?>
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
		<!--===================================== New game [end] =====================================-->
        
        <!--===================================== Feature [start] =====================================-->
		<div class="col-mn">
            <?php 
                $result = get_features();
                if (mysqli_num_rows($result) > 0) {
                    $games = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $content = excerpt_features($games['content']);
            ?>
			<div class="container">
                <div class="col-mn2">
                    
                    <h3><?= $games['title']; ?></h3>
                    <p><?= $content; ?>...</p>
                    <a class=" more-in" href="single.php?nid=<?= $games['news_id']; ?>">Read More</a>
                    <?php } ?>
				</div>
			</div>
		</div>
		<!--===================================== Feature [end] =====================================-->
		
        
        <div class="featured">
			<div class="container">
                <!--===================================== News [start] =====================================-->
				
                <!-- =============== Lastest News ============== -->
				<div class="col-md-4 latest">						
					<h4>Latest</h4>
					<?php 
						$result = get_lastest_news();
						if (mysqli_num_rows($result) > 0 ) {
							// Neu co post de hien thi thi in ra
							while ($lastest_news = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					?>
									<div class='late'>
										<a href='single.php?nid=<?= $lastest_news['news_id'] ?>' class='fashion'><img class='img-responsive' style="width: 120px; height: 120px;" src='images/<?= $lastest_news['image'] ?>' alt='<?= $lastest_news['image'] ?>'></a>
										<div class='grid-product'>
											<span><?= $lastest_news['date'] ?></span>
											<p><a href='single.php?nid={$lastest_news['news_id']}' ><?= $lastest_news['title'] ?></a></p>
											<a class='comment' href='single.php?nid={$lastest_news['news_id']}'><i> </i><?= $lastest_news['count']?> Comments</a>
										</div>
									<div class='clearfix'> </div>
									</div>
					<?php 
							}		
						}
					 ?>
				</div>

				<!-- =============== Hotest News ============== -->
				<div class="col-md-4 latest">
					<h4>Hotest</h4>
					<?php 
						$result = get_hotest_news();
						if (mysqli_num_rows($result) > 0 ) {
							// Neu co post de hien thi thi in ra
							while ($lastest_news = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					?>
									<div class='late'>
										<a href='single.php?nid=<?= $lastest_news['news_id'] ?>' class='fashion'><img class='img-responsive' style="width: 120px; height: 120px;" src='images/<?= $lastest_news['image'] ?>' alt='<?= $lastest_news['image'] ?>'></a>
										<div class='grid-product'>
											<span><?= $lastest_news['date'] ?></span>
											<p><a href='single.php?nid={$lastest_news['news_id']}' ><?= $lastest_news['title'] ?></a></p>
											<a class='comment' href='single.php?nid={$lastest_news['news_id']}'><i> </i><?= $lastest_news['count']?> Comments</a>
										</div>
									<div class='clearfix'> </div>
									</div>
					<?php 
							}		
						}
					 ?>
                </div>
                
				<!-- =============== Popular News ============== -->
				<div class="col-md-4 latest">
					<h4>Popular</h4>
					<?php 
						$result = get_popular_news();
						if (mysqli_num_rows($result) > 0 ) {
							// Neu co post de hien thi thi in ra
							while ($lastest_news = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					?>
									<div class='late'>
										<a href='single.php?nid=<?= $lastest_news['news_id'] ?>' class='fashion'><img class='img-responsive' style="width: 120px; height: 120px;" src='images/<?= $lastest_news['image'] ?>' alt='<?= $lastest_news['image'] ?>'></a>
										<div class='grid-product'>
											<span><?= $lastest_news['date'] ?></span>
											<p><a href='single.php?nid={$lastest_news['news_id']}' ><?= $lastest_news['title'] ?></a></p>
											<a class='comment' href='single.php?nid={$lastest_news['news_id']}'><i> </i><?= $lastest_news['count']?> Comments</a>
										</div>
									<div class='clearfix'> </div>
									</div>
					<?php 
							}		
						}
					 ?>
				</div>
                
				<div class="clearfix"></div>
				<!--===================================== News [end] =====================================-->
				             
                <!--===================================== Gallery [start] =====================================-->
				<div class="content-gallery">
					<h2 class="new" style="padding-bottom: 14px"> GALLERY </h2>
                    
					<div class="wrap">
						<table>
							<tbody>
								<tr>
									<td rowspan="2" style="width: 400px; height: 300px;">
                                        <?php 
                                        $result = get_first_image_gallery();
                                        if (mysqli_num_rows($result) > 0 ) {
                                            $gallery = mysqli_fetch_array($result, MYSQLI_ASSOC);  
                                        ?>
                                        <a href="gallery.php?iid=<?= $gallery['image_id'] ?>" ><img src="images/<?= $gallery['image']?>" alt="<?= $gallery['title']?>" width="400px" height="300px" ></a>
                                        <?php } ?>
                                    </td>
                                    <?php 
                                        $result = get_image_row1();
                                        if (mysqli_num_rows($result) > 0 ) {
                                            while ($gallery = mysqli_fetch_array($result, MYSQLI_ASSOC)){             
                                    ?>
                                    <td>                                      
                                        <a href="gallery.php?iid=<?= $gallery['image_id'] ?>" ><img src="images/<?= $gallery['image']?>" alt="<?= $gallery['title']?>" class="item-chil-row1" ></a>
									</td>
                                    <?php 
                                            }
                                        }                                       
                                    ?>                                   
									
								</tr>
								<tr>
									<?php 
                                        $result = get_image_row2();
                                        if (mysqli_num_rows($result) > 0 ) {
                                            while ($gallery = mysqli_fetch_array($result, MYSQLI_ASSOC)){             
                                    ?>
                                    <td>                                      
                                        <a href="gallery.php?iid=<?= $gallery['image_id'] ?>" ><img src="images/<?= $gallery['image']?>" alt="<?= $gallery['title']?>" class="item-chil-row1" ></a>
									</td>
                                    <?php 
                                            }
                                        }                                       
                                    ?> 
								</tr>

							</tbody>
						</table>
					</div>
        		</div>
        		<div class="clearfix"> </div>
				<!--===================================== Gallery [end] =====================================-->
                
                <!--===================================== Video [start] =====================================-->
				<div class="content-video">
					<h2 class="new" style="padding-bottom: 14px"> VIDEOS </h2>
					<div class="wrap">
						<table style="padding-top: 20px;">
							<tbody>
								<tr>
									<td rowspan="2" style="width: 400px; height: 350px;">
										<img src="images/w1.jpg" alt="" width="400px" height="300px" >
                                        <p>Title</p>
                                        <p>Description</p>
									</td>
									<td >
										<img src="images/w2.jpg" alt="" class="item-chil-row1" >
									</td>
									<td >
										<img src="images/w3.jpg" alt="" class="item-chil-row1" >
									</td>
									<td >
										<img src="images/w4.jpg" alt="" class="item-chil-row1" >
									</td>
									
								</tr>
								<tr>
									<td >
										<img src="images/w5.jpg" alt="" class="item-chil-row2" >
									</td>
									<td >
										<img src="images/w6.jpg" alt="" class="item-chil-row2" >
									</td>
									<td >
										<img src="images/w7.jpg" alt="" class="item-chil-row2" >
									</td>
								</tr>

							</tbody>
						</table>
					</div>
        		</div>
        		<div class="clearfix"> </div>		
			</div>
		</div>
        <!--===================================== Video [end] =====================================-->
	</div>
	<!---->
<?php include('includes/frontend/footer.php'); ?>	