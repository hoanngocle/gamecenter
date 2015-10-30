<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');
	?>
<?php
	if( $vid = validate_id($_GET['vid'])){
		$set = get_video_by_id($vid);
        
		$videos = array();
		if(mysqli_num_rows($set) > 0 ) {
		 	$videos = mysqli_fetch_array($set, MYSQLI_ASSOC);
		}else {
			redirect_to('admin/list_videos.php');	
		}
	}else{
		redirect_to('admin/list_videos.php');	
	}	
    $title_page = $videos['type_name'];
	include('../includes/backend/header-admin.php');
	?>

	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-11" style="margin-left: 48.75px">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $videos['type_name'] ?></h2>
                            <h4 style="text-align: center" ><a href="index.php">Home</a> / <a href="list_videos.php">List Videos</a></h4>
                        </div> <!-- END PANEL HEADING--> 

                        <div class="panel-body">
                            <div class="row" style="font-size : 18px">   
					            
								<!-- END HEADER PANEL -->

			                  	<div class="col-md-6" >
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Video ID :  </strong> <?=$videos['video_id']; ?> 
					                </div>
					            </div>
					            <div class="col-md-6" >
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Type : </strong> <?= $videos['type_name']; ?> 
					                </div>
					            </div>
                                <div class="col-md-6" >
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Posted By : </strong> <?= $videos['name']; ?>
					                </div>
					            </div>
					            

					            <div class="col-md-6" >
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Posted On : </strong> <?= $videos['date']; ?>
					                </div>
					            </div>
                                                            
                                <div class="col-md-12">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Title : </strong> <?= $videos['title']; ?> 
					                </div>
					            </div>
                                
                                <div class="col-md-12">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong style="font-size : 18px">Description  </strong>
				                        </div>
				                        <div class="panel-body">
				                            <p><?= $videos['description']; ?> </p>
				                        </div>				                        
				                    </div>
                            	</div>
                                
                                <div class="col-md-6">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong style="font-size : 18px">Video : </strong> 
				                        </div>
				                        <div class="panel-body">
                                            <video id="example_video_1" class="video-js vjs-default-skin" controls 
                                                preload="auto" width="450" height="340"
                                                poster="" 
                                                data-setup='{"techOrder":["youtube"], "src":"<?= $videos['url_video']; ?>"}' >
                                            </video>
				                        </div>				                        
				                    </div>
                            	</div>
                                
                                 <div class="col-md-6">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong style="font-size : 18px">Thumbnail : </strong> 
				                        </div>
				                        <div class="panel-body">
                                            <img class="img-responsive" style="width: 480px; height: 360px" src="/images/thumbnails/<?php echo $videos['thumbnail']; ?>" alt="<?php echo $videos['thumbnail']; ?>">
				                        </div>				                        
				                    </div>
                            	</div>
                                                               
                            	<div class="col-md-11">
                            		<center>
                            			<div class="alert alert-default">
                                            <a href="edit_video.php.php?vid=<?php echo $vid ?>" class="btn btn-success btn-lg" style="padding: 10px 35px"> Edit </a>
                                            <a href="#" id="delete" name="delete" class="btn btn-danger btn-lg" style="padding: 10px 25px ; margin-left: 40px" onClick="check_delete_video(<?= $vid ?>)">Delete</a>
						                </div>
                            		</center>   
					            </div>						
      						</div>
                        </div> <!-- END PANEL BODY-->
                    </div> <!-- END PANEL -->
    			</div>
    		</div> <!--  END ROW-->
		</div>
	</div>  <!-- END CONTENT -->

<?php include('../includes/backend/footer-admin.php'); ?>