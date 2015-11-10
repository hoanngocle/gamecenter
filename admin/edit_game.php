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

            // validate title null
			if (empty($_POST['title'])) {
				$errors[] = "title";
			} else {
				$title = mysqli_real_escape_string($dbc, strip_tags($_POST['title']));
			}

			// validate type null
            if (isset($_POST['type_id']) && filter_var($_POST['type_id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                $type_id = $_POST['type_id'];
            }else{
                $errors[] = 'type';
            }

			
            // validate avatar null
            if (empty($_FILES['myAvatar']['name'])) {
                $myAvatar = $games['image'];
            } else {
                $myAvatar =  $_FILES['myAvatar']['name'];
            }
            
            // validate banner null
            if (empty($_FILES['myBanner']['name'])) {
                $myBanner = $games['banner'];
            } else {
                $myBanner =  $_FILES['myBanner']['name'];
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
                $myAvatar = "ava-".$myAvatar; 
                $myBanner = "banner-".$myBanner;

                $targetava = '../images/'.$myAvatar;
                $targetbanner = '../images/'.$myBanner;
                move_uploaded_file($_FILES['myAvatar']['tmp_name'], $targetava  );
                move_uploaded_file($_FILES['myBanner']['tmp_name'], $targetbanner  );
                               
				$result = edit_news_games($gid, $title, $type_id, $myAvatar, $myBanner, $content, $status);
				if (mysqli_affected_rows($dbc) == 1) {
					echo "<script type='text/javascript'>
                            alert('{$lang['EDIT_OK']}');
                            window.location = 'list_games.php';
                            </script>      
                        ";
				} else {
                    echo "<script type='text/javascript'>
                            alert('{$lang['EDIT_FAIL']}');
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
                            <h2><?= $lang['Edit Games']?></h2>
                            <h4><a href="index.php"><?= $lang['Home']?></a> / <a href="list_games.php"><?= $lang['List Games']?></a></h4>
                        </div> <!-- END PANEL HEADING--> 
						<?php if(!empty($error)) : ?>
                            <div class='alert alert-danger' style='font-size: 18px; margin: 25px 35px'>
                                <p><?= $error?></p>
                            </div>
            			<?php endif; ?>
     <!-- ================================== Form Add News [start] ===================================== -->      
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="edit_news" action="" method="post" enctype="multipart/form-data"> 								<!-- ================= Title [start] =================== -->
								<div class="form-group"  style="font-size: 18px" >
								   	<label for="title"><?= $lang['Title'] ?></label>
								    <input style="font-size: 18px; height: 44px" type="text" class="form-control" id="title" name="title" size="20" maxlength="150" placeholder="<?= $lang['Enter_title']?>" value="<?php if(isset($games['title'])) echo $games['title']; ?>"/>
                                <?php if(isset($errors) && in_array('title', $errors)) : ?>
                                    <div class='alert alert-warning' style='font-size: 16px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                        <p><?= $lang['AD_Title_required'] ?></p>
                                    </div>
                                <?php endif; ?>
								</div>
                                
								<!-- ================= Type [start] =================== -->
				     			<div class="form-group" style="font-size: 18px">
				                    <label><?= $lang['Select_Type']?></label>
				                    
				                    <select name="type_id" class="form-control" style="font-size: 18px; height: 44px">
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
										<div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
											<p><?= $lang['AD_Type_required'] ?></p>
	                    				</div>
                                    <?php endif; ?>
				                </div>  
                                
								<!-- ================= Avatar [start] ===================== -->
								<div class="form-group" style="font-size: 18px">
								    <label for="image"><?= $lang['Images Input'] ?></label> <br>
								    <img id="avatar" style="width: 300px; height: 300px;" />
                                    <input  name="myAvatar"  style="margin-top: 15px" id="uploadAvatar" type="file" onchange="PreviewAvatar()();" value="<?php if(isset($games['image'])) echo $games['image'];  ?>"/>
								</div>   
                                
								<!-- ================= Banner [start] ===================== -->
								<div class="form-group" style="font-size: 18px">
				                    <label for="banner">Banner Input</label> <br>
				                    <img id="banner" style="width: 800px; height: 200px;" />
									<input name="myBanner" style="margin-top: 15px" id="uploadBanner" type="file"  onchange="PreviewBanner();" />
					            </div>	
                                
								<!-- ================= Content [start] ===================== -->	
								<div class="form-group" style="font-size: 18px">
								   	<label for="content">Content</label>
								    <textarea id="content" name="content" class="form-control" cols="20" rows="15" style="font-size: 15px" size="20" maxlength="2000" placeholder="Please text some content"><?php if(isset($games['content'])) echo htmlentities($games['content'], ENT_COMPAT, 'UTF-8'); ?></textarea>
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
				                        <option value="0" <?php if (isset($games['status']) && ($games['status'] == 0 )) echo "selected='selected'"; ?>><?= $lang['Inactive']?></option>
				                        <option value="1" <?php if (isset($games['status']) && ($games['status'] == 1 )) echo "selected='selected'"; ?>><?= $lang['Active']?></option>
				                    </select>
				                </div>
                                
								<!-- Update Button -->
								<center >
									<input type="submit" name="submit" class="btn btn-success" style="font-size: 18px; height: 44px; margin-right: 10px"  value="<?= $lang['Update']?>">
								</center>							
							</form> <!-- END FORM ADD NEWS-->				 
                        </div>
		          	</div> <!-- END PANEL BODY-->
				</div>
			</div>
		</div> <!-- END ROWS -->
    </div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>
