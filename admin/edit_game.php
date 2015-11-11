<!-- 
    File       : edit_games.php
    Created on : Jul 11, 2015, 10:26:53 AM
    Updated on : Nov 11, 2015, 10:26:53 AM   
    Author     : Béo
-->
<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');

    $title_page = 'Edit Game';
	if( $gid = validate_id($_GET['gid'])){
        $query = "SELECT * FROM tblnews WHERE news_id = {$gid}";
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        if (mysqli_num_rows($result) == 1) {
            $games = mysqli_fetch_array($result, MYSQLI_ASSOC);
        } else {
            redirect_to('admin/list_games.php');
        }

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$errors = array();

            // validate title 
			if (empty($_POST['title'])) {
				$errors[] = "title";
			} else {
				$title = mysqli_real_escape_string($dbc, strip_tags($_POST['title']));
			}

			// validate type 
            if (isset($_POST['type_id']) && filter_var($_POST['type_id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                $type_id = $_POST['type_id'];
            }else{
                $errors[] = 'type';
            }

			
            // validate avatar null
            if (empty($_FILES['myAvatar']['name'])) {
                $myAvatar = $games['image'];
            } else {
                $check = checkImgGame($_FILES['myAvatar']['name']);
                if(mysqli_num_rows($check) > 0){
                    $errors[] = 'existIMG';
                }else {
                    $myAvatar =  $_FILES['myAvatar']['name']; 
                }               
            }
            
            // validate banner null
            if (empty($_FILES['myBanner']['name'])) {
                $myBanner = $games['banner'];
            } else {
                $check = checkBannerGame($_FILES['myBanner']['name']);
                if(mysqli_num_rows($check) > 0){
                    $errors[] = 'existBanner';
                }else {
                    $myBanner =  $_FILES['myBanner']['name']; 
                }  
            }			
			
			// validate content null
			if (empty($_POST['content'])) {
				$errors[] = 'content';
			}else {
				$content = mysqli_real_escape_string($dbc, $_POST['content']);
			}

            // validate status null
            if (isset($_POST['status'])) {
                $status = $_POST['status'];
            }else{
                $errors[] = 'status';
            }
            
			if (empty($errors)) {
                $targetava = '../images/gallery/'.$myAvatar;
                $targetbanner = '../images/gallery/'.$myBanner;
                move_uploaded_file($_FILES['myAvatar']['tmp_name'], $targetava  );
                move_uploaded_file($_FILES['myBanner']['tmp_name'], $targetbanner  );
                               
				$result = edit_news_games($gid, $title, $type_id, $myAvatar, $myBanner, $content, $status);
				if (mysqli_affected_rows($dbc) == 1) {
					echo "<script type='text/javascript'>
                            alert('{$lang['AD_EDIT_GAME_SUCCESS']}');
                            window.location = 'list_games.php';
                            </script>      
                        ";
				} else {
                    echo "<script type='text/javascript'>
                            alert('{$lang['AD_EDIT_FAIL']}');
                            window.location = 'list_games.php';
                            </script>      
                        ";
				} 
			} else {
				$error = $lang['AD_REQUIRED'];
			}
		} // END main IF submit condition

	}else {
        redirect_to('admin/list_games.php');
    }
	include('../includes/backend/header-admin.php');
?>
	<div class="content-wrapper">
        <div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['ADD_GAME_PAGE_HEADER']?></h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 4.1%">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2><?= $lang['EDIT_GAME_H2'] ?></h2>
                            <h4><a href="index.php"><?= $lang['ADD_GAME_LINK_HOME']?></a> / <a href="list_games.php"><?= $lang['ADD_GAME_LINK_LIST']?></a></h4>
                        </div> <!-- END PANEL HEADING--> 
						<?php if(!empty($error)) : ?>
                            <div class='message-error alert alert-danger'>
                                <p><?= $error?></p>
                            </div>
            			<?php endif; ?>
     <!-- ================================== FORM EDIT GAME [start] ===================================== -->      
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="edit_news" action="" method="post" enctype="multipart/form-data"> 
                                
                                <!-- ================= Title [start] =================== -->
								<div class="label-fontsize form-group" >
								   	<label for="title"><?= $lang['ADD_GAME_FORM_TITLE_LABEL'] ?></label>
								    <input style="height: 44px" type="text" class="label-fontsize form-control" id="title" name="title" size="20" maxlength="150" placeholder="<?= $lang['ADD_GAME_FORM_TITLE_TEXT']?>" value="<?php if(isset($games['title'])) echo $games['title']; ?>"/>
                                <?php if(isset($errors) && in_array('title', $errors)) : ?>
                                    <div class='message alert alert-warning'>
                                        <p><?= $lang['ADD_GAME_FORM_TITLE_REQUIRED'] ?></p>
                                    </div>
                                <?php endif; ?>
								</div>
                                
								<!-- ================= Type [start] =================== -->
				     			<div class="label-fontsize form-group" >
				                    <label><?= $lang['ADD_GAME_FORM_TYPE']?></label>
				                    
				                    <select name="type_id" class="label-fontsize form-control" style="height: 44px">
				                        <option>-------</option>
				                        <?php 
											$query = "SELECT type_id, type_name FROM tbltypes ORDER BY type_id ASC";
											$result = mysqli_query($dbc, $query);
											if(mysqli_num_rows($result) > 0){
												while($types = mysqli_fetch_array($result, MYSQLI_NUM)){
													echo "<option value='{$types[0]}'"; 
														if (isset($games['type_id']) && ($games['type_id'] == $types[0])) echo "selected='selected'";
													echo ">".$types[1]."</option>";	
												}
											}
										 ?>
				                    </select>
				                    <?php if (isset($errors) && in_array('type', $errors)) : ?>
										<div class='message alert alert-warning'>
											<p><?= $lang['ADD_GAME_FORM_TYPE_REQUIRED'] ?></p>
	                    				</div>
                                    <?php endif; ?>
				                </div>  
                                
								<!-- ================= Avatar [start] ===================== -->
								<div class="label-fontsize form-group" >
								    <label for="image"><?= $lang['ADD_GAME_FORM_IMG'] ?></label> <br>
                                    <?php if(isset($games['image'])): ?>
                                    <img id="avatar" class="avatar" src="../images/gallery/<?= $games['image']?>"/>       
                                    <?php else: ?>
				                    <img id="avatar" class="avatar" />
                                    <?php endif; ?>
                                    <input  name="myAvatar"  style="margin-top: 15px" id="uploadAvatar" type="file" onchange="PreviewAvatar()();" value="<?php if(isset($games['image'])) echo $games['image'];  ?>"/>
                                    <?php if (isset($errors) && in_array('existImg', $errors)) : ?>
										<div class='message alert alert-warning'>
                                            <p><?= $lang['ADD_IMAGE_FORM_IMG_REQUIRED'] ?></p>
                                        </div>
                                    <?php endif;?>
								</div>   
                                
								<!-- ================= Banner [start] ===================== -->
								<div class="label-fontsize form-group">
				                    <label for="banner"><?= $lang['ADD_GAME_FORM_BANNER']?></label> <br>
                                    <?php if(isset($games['banner'])): ?>
                                    <img id="banner" class="banner" src="../images/gallery/<?= $games['banner']?>"/>       
                                    <?php else : ?>
                                    <img id="banner" class="banner" />
                                    <?php endif; ?>
									<input name="myBanner" style="margin-top: 15px" id="uploadBanner" type="file"  onchange="PreviewBanner();" value="<?php if(isset($games['banner'])) echo $games['banner'];  ?>"/>
                                    <?php if (isset($errors) && in_array('existBanner', $errors)) : ?>
										<div class='message alert alert-warning'>
                                            <p><?= $lang['ADD_IMAGE_FORM_IMG_REQUIRED'] ?></p>
                                        </div>
                                    <?php endif;?>
					            </div>	
                                
								<!-- ================= Content [start] ===================== -->	
								<div class="label-fontsize form-group">
								   	<label for="content"><?= $lang['ADD_GAME_FORM_CONTENT']?></label>
								    <textarea id="content" name="content" class="form-control" cols="20" rows="15" style="font-size: 15px" size="20" maxlength="2000" placeholder="<?= $lang['ADD_GAME_FORM_CONTENT_TEXT']?>"><?php if(isset($games['content'])): echo htmlentities($games['content'], ENT_COMPAT, 'UTF-8'); endif; ?></textarea>
                                    <script>CKEDITOR.replace('content'); </script>
								<?php if (isset($errors) && in_array('content', $errors)) : ?>
                                    <div class='message alert alert-warning'>
                                        <p><?= $lang['ADD_GAME_FORM_CONTENT_REQUIRED']?></p>
                                    </div>
                                <?php endif; ?>								
								</div>
								
                                <!-- ================= Status: default is 0 [start] ===================== -->
                                <div class="label-fontsize form-group">
				                    <label><?= $lang['ADD_GAME_FORM_STATUS']?></label>
				                    <select name="status" class="label-fontsize form-control" style="height: 44px">										
				                        <option value="0" <?php if (isset($games['status']) && ($games['status'] == 0 )) echo "selected='selected'"; ?>><?= $lang['ADD_GAME_FORM_STATUS_VAL_0']?></option>
				                        <option value="1" <?php if (isset($games['status']) && ($games['status'] == 1 )) echo "selected='selected'"; ?>><?= $lang['ADD_GAME_FORM_STATUS_VAL_1']?></option>
				                    </select>
				                </div>
                                
								<!-- Button -->
								<center >
									<input type="submit" name="submit" class="btncustom btn btn-success" style="margin-right: 5px"  value="<?= $lang['BUTTON_UPDATE']?>">
                                    <input type="reset" class="btncustom btn btn-warning" style="margin-right: 5px" value="<?= $lang['BUTTON_RESET'] ?>">
                                    <input type="button" class="btncustom btn btn-danger" onclick="window.history.back();" value="<?= $lang['BUTTON_BACK'] ?>">
								</center>							
							</form> <!-- END FORM EDIT GAME-->				 
                        </div>
		          	</div> <!-- END PANEL BODY-->
				</div>
			</div>
		</div> <!-- END ROWS -->
    </div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>
