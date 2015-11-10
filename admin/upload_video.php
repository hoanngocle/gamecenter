<?php
    $title_page = 'Upload Video';
    include('../includes/functions.php');
	include('../includes/backend/header-admin.php');
	include('../includes/backend/mysqli_connect.php');
    include('../includes/errors.php');
?>

<?php 
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$errors = array();

		if (empty($_POST['url'])) {
			$errors[] = "url";
		}else{
            $url = mysqli_real_escape_string($dbc, $_POST['url']);
            $check = checkIDVideo($url);
            
            if(mysqli_num_rows($check) == 1){
                $errors[] = "exist";     
            }else{
                if(!youtube_id_from_url($url)){  
                    $id_url = null;
                    $fail = $lang['AD_video_msg_fail'];
                }else {
                    $id_url = youtube_id_from_url($url);
                }
            }
        } 
        if (isset($errors) && in_array('url', $errors)){
            $error = $lang['AD_REQUIRED'];
        }else if (isset($errors) && in_array('exist', $errors)){
            $error = $lang['AD_Exist'];
        }
		
    } // END main IF submit condition
?>
	<div class="content-wrapper">
        <div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['Upload_Videos'] ?></h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 47.25px">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2><?= $lang['Upload_Videos'] ?></h2>
                            <h4><a href="index.php"><?= $lang['Home']?></a> / <a href="list_videos.php"><?= $lang['List_Videos']?></a></h4>
                        </div> <!-- END PANEL HEADING--> 
						<?php 
            				if(!empty($fail)) {
								echo " <div class='alert alert-danger' style='font-size: 18px; margin: 25px 35px'>
											<p>{$fail}</p>
            							</div>";
            						}
            				if(!empty($error)) {
								echo " <div class='alert alert-danger' style='font-size: 18px; margin: 25px 35px'>
											<p>{$error}</p>
            							</div>";
            						}
                        ?>
                        
    <!-- ================================== Form Add Images [start] ===================================== -->
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="add_videos" action="" method="post" enctype="multipart/form-data">
                                
                                <!-- ================= Title [start] =================== -->
								<div class="form-group"  style="font-size: 18px" >
								   	<label for="title"><?= $lang['Check_Url']?></label>
                                    <input style="font-size: 18px; height: 44px;" type="text" class="form-control" id="url" name="url" placeholder="<?= $lang['Enter_Url']?>" value="<?php if(isset($url)) echo $url ?>" />
                                    <br>
                                    <center>
                                    <input type="submit" name="submit" class="btn btn-success" style="font-size: 18px; height: 44px; margin-right: 10px"  value="<?= $lang['Check']?>">
                                    </center>
								<?php 
                                    if (isset($errors) && in_array('title', $errors)) {
                                ?>
                                        <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                            <p><?= $lang['AD_Url_required']?></p>
                                        </div>
                                <?php
                                    }
                                ?>
								</div>
                                
                                <!-- ================= ID Url [start] =================== -->
                                <?php 
                                    if(!empty($id_url)){
                                ?>                               
								<div class="form-group"  style="font-size: 18px" >
                                    <label for="title"><?= $lang['ID_Video']?></label>
                                    <input style="font-size: 18px; height: 44px" type="text" class="form-control" id="url" name="url" value="<?php if(isset($id_url[1])) echo $id_url[1] ?>" disabled/>
								</div>      
                                
                                <!-- ================= Video [start] =================== -->
								<div class="form-group"  style="font-size: 18px" >
								   	<label for="title"><?= $lang['Video'] ?></label>   
                                    <div style="margin-left: 17%; margin-top: 2%">
                                        <video id="example_video_1" class="video-js vjs-default-skin" controls 
                                        preload="auto" width="640" height="360"
                                        poster="" 
                                        data-setup='{"techOrder":["youtube"], "src":"<?= $url ?>"}' >
                                        </video>
                                    </div>   								
                                </div>  
                                                               
                                <!-- ================= Thumbnail [start] =================== -->
								<div class="form-group"  style="font-size: 18px" >
								   	<label for="title"><?= $lang['Thumbnail']?></label>
                                    <br>
                                    <img style="width: 640px; height: 480px; margin-left: 17%; margin-top: 2%" src="http://img.youtube.com/vi/<?= $id_url[1] ?>/sddefault.jpg" alt="thumbnail" title="thumbnail" id="wows1_0"/>
								</div>  
                                                        
								<!-- ================= Submit & Reset Button [start] ===================== -->
								<center >
									<input type="button" onclick="location.href='/admin/add_video.php?vid=<?= $id_url[1]?>';" name="send" class="btn btn-success" style="font-size: 18px; height: 44px; margin-right: 10px"  value="<?= $lang['Submit']?>">
									<button type="button" onclick="location.href='/admin/list_games.php';" class="btn btn-danger" style="font-size: 18px; height: 44px"><?= $lang['Cancel']?></button>
                                <?php     
                                    }  
                                ?>
								</center>							
							</form> <!-- END FORM ADD VIDEO-->				 
						</div> 
		          	</div> <!-- END PANEL BODY-->
				</div>

    <!-- ================================== Form Upload Video [end] ===================================== -->		
			</div>
		</div> <!-- END CONTAINER-->
    </div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>
