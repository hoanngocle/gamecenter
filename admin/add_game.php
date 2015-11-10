<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');
?>

<?php
    $title_page = 'Add Game';
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){ // gia tri ton tai, xu ly form
		// create variable error
		$errors = array();
        $uid = $_SESSION['uid'];
		// validate title
		if (empty($_POST['title'])) {
			$errors[] = "title";
		} else {
			$title = mysqli_real_escape_string($dbc, strip_tags($_POST['title']));
		}

		// validate type
		if (isset($_POST['type']) && filter_var($_POST['type'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
			$type_id = $_POST['type'];
		}else{
			$errors[] = 'type';
		}

		// validate Avatar
		if (empty($_FILES['myAvatar']['name'])) {
			$errors[] = "myAvatar";
		} else {
			$myAvatar =  $_FILES['myAvatar']['name'];
		}

		// validate Banner
		if (empty($_FILES['myBanner']['name'])) {
			$errors[] = "myBanner";
		} else {
			$myBanner = $_FILES['myBanner']['name'];
		}
		
		// kiem tra content co gia tri hay ko
		if (empty($_POST['content'])) {
			$errors[] = 'content';
		}else {
			$content = $_POST['content'];
		}

        //kiem tra trang thai bai viet co gia tri hay ko
        if (isset($_POST['status'])) {
            $status = $_POST['status'];
        }else{
            $errors[] = 'status';
        }
            
		// kiem tra xem co loi hay khong
		if (empty($errors)) {
			// neu ko co loi xay ra bat dau chen vao CSDL
            $myAvatar = "ava-".$myAvatar; 
            $myBanner = "banner-".$myBanner;
            
            $targetava = '../images/'.$myAvatar;
            $targetbanner = '../images/'.$myBanner;
            move_uploaded_file($_FILES['myAvatar']['tmp_name'], $targetava  );
            move_uploaded_file($_FILES['myBanner']['tmp_name'], $targetbanner  );
            
            $query = "INSERT INTO tblnews ( user_id, type_id, title, image, banner, content, status, create_date)
						VALUES ({$uid}, {$type_id}, '{$title}','{$myAvatar}','{$myBanner}','{$content}', '{$status}', NOW())";			
			$result = mysqli_query($dbc, $query);
			// ham tra ve ket qua co dung hay ko
			confirm_query($result, $query);

			if (mysqli_affected_rows($dbc) == 1) {
                echo "<script type='text/javascript'>
                        alert('{$lang['ADD_OK']}');
                        window.location = 'list_games.php';
                        </script>      
                    ";
            } else {
                echo "<script type='text/javascript'>
                        alert('{$lang['ADD_FAIL']}');
                        window.location = 'list_games.php';
                        </script>      
                    ";
            }
		} else {
			$error = $lang['AD_REQUIRED'];
		}
	} // END main IF submit condition
    include('../includes/backend/header-admin.php');    
?>
<!-- Script ################## -->
	<div class="content-wrapper">
        <div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['Manage Games']?></h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 47.25px">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2><?= $lang['Add Games']?></h2>
                            <h4><a href="index.php"><?= $lang['Home'] ?></a> / <a href=list_games.php"><?= $lang['List Games']?></a></h4>
                        </div> <!-- END PANEL HEADING--> 
						<?php if(!empty($error)) : ?>
                            <div class='alert alert-danger' style='font-size: 18px; margin: 25px 35px'>
                                <p><?= $error?></p>
                            </div>
            			<?php endif; ?>
    <!-- ================================== Form Add Games [start] ===================================== -->
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="add_news" action="" method="post" enctype="multipart/form-data">
                                <!-- ================= Title [start] =================== -->
								<div class="form-group"  style="font-size: 18px" >
                                    <label for="title"><?= $lang['Title'] ?></label>
                                    <input style="font-size: 18px; height: 44px" type="text" class="form-control" id="title" name="title" size="20" maxlength="150" placeholder="<?= $lang['Enter_title']?>  " value="<?php if(isset($title)) echo $title ?>"/>
								<?php if(isset($errors) && in_array('title', $errors)) : ?>
                                    <div class='alert alert-warning' style='font-size: 16px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                        <p><?= $lang['AD_Title_required'] ?></p>
                                    </div>
                                <?php endif; ?>
								</div>
                                
								<!-- ================= Type [start] ===================== -->
				     			<div class="form-group" style="font-size: 18px">
				                    <label><?= $lang['Select_Type']?></label>
				                    
				                    <select name="type" class="form-control" style="font-size: 18px; height: 44px">
				                        <option>-------</option>
				                        <?php 
											$query = "SELECT type_id, type_name FROM tbltypes WHERE cat_id = 2 ORDER BY type_id ASC";
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

								<!-- ================= Avatar [start] ===================== -->
								<div class="form-group" style="font-size: 18px">
								    <label for="image"><?= $lang['Images Input'] ?></label> <br>
								    <img id="avatar" style="width: 300px; height: 300px;" />
                                    <input  name="myAvatar"  style="margin-top: 15px" id="uploadAvatar" type="file" onchange="PreviewAvatar(); " />
								</div>
                                <?php if (isset($errors) && in_array('myAvatar', $errors)) : ?>
                                    <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                        <p><?= $lang['AD_image_required'] ?></p>
                                    </div>
                                <?php endif; ?>
                                
								<!-- ================= Banner [start] ===================== -->
								<div class="form-group" style="font-size: 18px">
				                    <label for="banner"><?= $lang['Banner Input'] ?></label> <br>
				                    <img id="banner" style="width: 800px; height: 200px;" />
									<input name="myBanner" style="margin-top: 15px" id="uploadBanner" type="file" onchange="PreviewBanner();" />
					            </div>	

								<?php if (isset($errors) && in_array('myBanner', $errors)) : ?>
									<div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                        <p><?= $lang['AD_Banner_required']?></p>
                                    </div>
                                <?php endif; ?>
      
								<!-- ================= Content [start] ===================== -->
								<div class="form-group" style="font-size: 18px">
								   	<label for="content"><?= $lang['Content'] ?></label>
								    <textarea id="content" name="content" class="form-control" rows="15" style="font-size: 15px" size="20" maxlength="2000" placeholder="<?= $lang['Place_content']?>" value="<?php if(isset($content)) echo $content ?>"></textarea>
                                    <script>CKEDITOR.replace('content'); </script>
								<?php if (isset($errors) && in_array('content', $errors)) : ?>
                                    <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                        <p><?= $lang['AD_Content_required']?></p>
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
							</form> <!-- END FORM ADD GAMES-->				 
						</div> 
		          	</div> <!-- END PANEL BODY-->
				</div>               
    <!-- ================================== Form Add GAME [end] ===================================== -->		
			</div>
		</div> 
    </div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>
