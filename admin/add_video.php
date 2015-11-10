<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');
?>

<?php    
    $vid = $_GET['vid'];         
    if(empty($vid) || strlen($vid) != 11){
        redirect_to('admin/list_videos.php');       
    }else {
  
            $title_page = 'Add Video';
            $video = get_youtube($vid);
            $title = $video['title'];
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
                // create variable error
                $errors = array();
                $uid = $_SESSION['uid'];


                // kiem tra xem type co gia tri hay ko
                if (isset($_POST['type']) && filter_var($_POST['type'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                    $type_id = $_POST['type'];
                }else{
                    $errors[] = 'type';
                }

                if (empty($_POST['description'])) {
                    $errors[] = "description";
                } else {
                    $description = mysqli_real_escape_string($dbc, strip_tags($_POST['description']));
                }

                // kiem tra xem url video co gia tri hay ko

                $url_video = "https://www.youtube.com/watch?v=$vid";
                $url_thumbnail ="http://img.youtube.com/vi/$vid/sddefault.jpg";

                //kiem tra trang thai bai viet co gia tri hay ko
                if (isset($_POST['status'])) {
                    $status = $_POST['status'];
                }else{
                    $errors[] = 'status';
                }

                $thumbnail = save_thumbnail_from_url($url_thumbnail, $vid);
                // kiem tra xem co loi hay khong
                if (empty($errors)) {
                    // neu ko co loi xay ra bat dau chen vao CSDL
                    $query = "INSERT INTO tblvideos (user_id, title, type_id, description, thumbnail, url_video, status, create_date )
                                VALUES ({$uid}, '{$title}', {$type_id}, '{$description}', '{$thumbnail}', '{$url_video}', '{$status}', NOW())";			
                    $result = mysqli_query($dbc, $query);
                    // ham tra ve ket qua co dung hay ko
                    confirm_query($result, $query);

                    if (mysqli_affected_rows($dbc) == 1) {
                        echo "<script type='text/javascript'>
                                alert('{$lang['ADD_OK']}');
                                window.location = 'list_videos.php';
                                </script>      
                            ";
                    } else {
                        echo "<script type='text/javascript'>
                                alert('{$lang['ADD_FAIL']}');
                                window.location = 'list_videos.php';
                                </script>      
                            ";
                    }
                } else {
                    $error = $lang['AD_REQUIRED'];
                }
            }
        }
    
    include('../includes/backend/header-admin.php');

?>
<!-- Script ################## -->
	<div class="content-wrapper">
        <div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['Manage_Videos']?></h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 47.25px">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2><?= $lang['Add_Videos']?></h2>
                            <h4><a href="index.php"><?= $lang['Home']?></a> / <a href="list_videos.php"><?= $lang['List_Videos']?></a></h4>
                        </div> <!-- END PANEL HEADING-->  
                        <?php if(!empty($error)) : ?>
                            <div class='alert alert-danger' style='font-size: 18px; margin: 25px 35px'>
                                <p><?= $error?></p>
                            </div>
            			<?php endif; ?>
    <!-- ================================== Form Add Images [start] ===================================== -->
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="add_videos" action="" method="post" >
                                <!-- ================= Title [start] =================== -->
								<div class="form-group"  style="font-size: 18px" >
								   	<label for="title"><?= $lang['Title'] ?></label>
                                    <input style="font-size: 18px; height: 44px" type="text" class="form-control" id="title" name="title" placeholder="<?= $lang['Enter_title']?> " value="<?= $video['title'] ?>"/>
								</div>
                                
								<!-- ================= Type [start] ===================== -->
				     			<div class="form-group" style="font-size: 18px">
				                    <label><?= $lang['Select_Type']?></label>
				                    
				                    <select name="type" class="form-control" style="font-size: 18px; height: 44px">
				                        <option>-------</option>
				                        <?php 
											$query = "SELECT type_id, type_name FROM tbltypes WHERE cat_id = 4 ORDER BY type_id ASC";
											$result = mysqli_query($dbc, $query);
											if(mysqli_num_rows($result) > 0){
												while($types = mysqli_fetch_array($result, MYSQLI_NUM)){
													echo "<option value='{$types[0]}'"; 
														if (isset($_POST['type']) && ($_POST['type'] == $types[0])) echo "selected='selected'";
													echo ">".$types[1]."</option>";	
												}
											}
										 ?>
				                    </select>
				                    <?php if (isset($errors) && in_array('type', $errors)) : ?>
										<div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
											<p><?= $lang['AD_Type_required'] ?></p>
	                    				</div>
                                    <?php endif; ?>
				                </div>

								<!-- ================= Url_video [start] =================== -->
								<div class="form-group"  style="font-size: 18px" >
                                    <label for="title"><?= $lang['Url_Videos']?></label>
                                    <input style="font-size: 18px; height: 44px" type="text" class="form-control" id="url" name="url" size="20" maxlength="150" value="https://www.youtube.com/watch?v=<?= $vid ?>" disabled/>
								</div>
                                
                                <!-- ================= Description [start] =================== -->
								<div class="form-group"  style="font-size: 18px" >
                                    <label for="title"><?= $lang['Description']?></label>
                                    <textarea id="description" name="description" class="form-control" rows="4" style="font-size: 18px" size="20" maxlength="1000" placeholder="<?= $lang['Place_Des']?>" value="<?php if(isset($description)) echo $description ?>"></textarea>
								<?php if (isset($errors) && in_array('description', $errors)) : ?>
                                    <div class='alert alert-warning' style='font-size: 16px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                        <p><?= $lang['AD_Description_required']?></p>
                                    </div>
                                <?php endif; ?>
								</div>
								
                                <!-- ================= Status: default is 0 [start] ===================== -->
                                <div class="form-group" style="font-size: 18px">
				                    <label><?= $lang['Select_Status']?></label>

				                    <select name="status" class="form-control" style="font-size: 18px; height: 44px">
				                        <option value="0"><?= $lang['Inactive']?></option>
				                        <option value="1"><?= $lang['Active']?></option>
				                    </select>
				                </div>
                                
								<!-- ================= Submit & Reset Button [start] ===================== -->
								<center >
									<input type="submit" name="submit" class="btn btn-success" style="font-size: 18px; height: 44px; margin-right: 10px"  value="<?= $lang['Submit']?>">
									<button type="reset" class="btn btn-danger" style="font-size: 18px; height: 44px"><?= $lang['Reset']?></button>
								</center>
                                
							</form> <!-- END FORM ADD VIDEOS-->				 
						</div> 
		          	</div> <!-- END PANEL BODY-->
				</div>
    <!-- ================================== Form Add Videos [end] ===================================== -->		
			</div>
		</div> 
    </div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>
