<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');

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
                <div class="col-md-11" style="margin-left: 4.1%">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $videos['type_name'] ?></h2>
                            <h4 style="text-align: center" ><a href="index.php"><?= $lang['ADD_VIDEO_LINK_HOME']?></a> / <a href="list_videos.php"><?= $lang['ADD_VIDEO_LINK_LIST'] ?></a></h4>
                        </div> <!-- END PANEL HEADING--> 

                        <div class="panel-body">
                            <div class="show-fontsize row">   
			                  	<div class="col-md-6" >
					                <div class="show-fontsize alert alert-success">
                                        <strong>Video ID :  </strong> <?=$videos['video_id']; ?> 
					                </div>
					            </div>
					            <div class="col-md-6" >
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_TYPE']?> : </strong> <?= $videos['type_name']; ?> 
					                </div>
					            </div>
                                <div class="col-md-6" >
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_POST_BY'] ?> : </strong> <?= $videos['name']; ?>
					                </div>
					            </div>
					            

					            <div class="col-md-6" >
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_POST_ON']?> : </strong> <?= $videos['date']; ?>
					                </div>
					            </div>
                                                            
                                <div class="col-md-12">
					                <div class="show-fontsize alert alert-success">
					                 	<strong class="show-fontsize"><?= $lang['TABLE_TITLE']?> : </strong> <?= $videos['title']; ?> 
					                </div>
					            </div>
                                
                                <div class="col-md-12">
									<div class="panel panel-success">
				                        <div class="show-fontsize panel-heading">
				                            <strong><?= $lang['TABLE_DESCRIPTION'] ?>  </strong>
				                        </div>
				                        <div class="panel-body">
				                            <p><?= $videos['description']; ?> </p>
				                        </div>				                        
				                    </div>
                            	</div>
                                
                                <div class="col-md-6">
									<div class="panel panel-success">
				                        <div class="show-fontsize panel-heading">
				                            <strong><?= $lang['TABLE_VIDEO']?> : </strong> 
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
				                        <div class="show-fontsize panel-heading">
				                            <strong><?= $lang['TABLE_THUMBNAIL']?> : </strong> 
				                        </div>
				                        <div class="panel-body">
                                            <img class="img-responsive" style="width: 480px; height: 340px" src="/images/thumbnails/<?php echo $videos['thumbnail']; ?>" alt="<?php echo $videos['thumbnail']; ?>">
				                        </div>				                        
				                    </div>
                            	</div>
                                
                                <div class="col-md-11" style="margin-left: 43.75px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px"><?= $lang['TABLE_STATUS']?> : </strong>
                                        <?php if ($videos['status'] == 0){
                                            echo "Inactive";
                                        }else{
                                            echo "Active";
                                        } ?> 
					                </div>
					            </div>
                                                               
                            	<div class="col-md-12">
                            		<center>
                            			<div class="alert alert-default">
                                            <input type="button" class="btncustom btn btn-success" onclick="window.location='edit_video.php?vid=<?= $vid ?>';" value="<?= $lang['BUTTON_EDIT'] ?>">
                                            <input type="button" class="btncustom btn btn-warning" onClick="check_delete_video(<?= $vid ?>);" value="<?= $lang['BUTTON_DELETE'] ?>">
                                            <input type="button" class="btncustom btn btn-danger" onclick="window.history.back();" value="<?= $lang['BUTTON_BACK'] ?>">
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