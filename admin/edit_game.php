<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');
?>

<?php 
	// Kiem tra gia gtri cua bien pid tu $_GET
	if( $gid = validate_id($_GET['gid'])){

	// Chon news trong CSDL de hien thi ra trinh duyet
        $query = "SELECT * FROM tblnews WHERE news_id = {$gid}";
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        if (mysqli_num_rows($result) == 1) {
            // Neu co page tra ve
            $games = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }else {
            // Neu khong co page tra ve
            $messages = "Bài viết không tồn tại!";
        }


		if ($_SERVER['REQUEST_METHOD'] == 'POST') { // gia tri ton tai, xu ly form
			//tao bien luu loi
			$errors = array();

			// kiem tra page name co gia tri hay khong
			if (empty($_POST['title'])) {
				$errors[] = "title";
			} else {
				$title = mysqli_real_escape_string($dbc, strip_tags($_POST['title']));
			}

			// kiem tra xem type co gia tri hay ko
            if (isset($_POST['type_id']) && filter_var($_POST['type_id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                $type_id = $_POST['type_id'];
            }else{
                $errors[] = 'type';
            }

			
            // kiem tra avatar co gia tri hay khong
            if (empty($_FILES['myAvatar']['name'])) {
                $myAvatar = $games['image'];
            } else {
                $myAvatar =  $_FILES['myAvatar']['name'];
            }
            
            // kiem tra banner co gia tri hay khong
            if (empty($_FILES['myBanner']['name'])) {
                $myBanner = $games['banner'];
            } else {
                $myBanner =  $_FILES['myBanner']['name'];
            }			
			
			// kiem tra content co gia tri hay ko
			if (empty($_POST['content'])) {
				$errors[] = 'content';
			}else {
				$content = mysqli_real_escape_string($dbc, $_POST['content']);
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
				$result = edit_news($gid, $title, $type_id, $myAvatar, $myBanner, $content, $status);
				if (mysqli_affected_rows($dbc) == 1) {
					$success = "Chỉnh sửa bài viết thành công!";
				} else {
					$fail = "Chỉnh sửa bài viết thất bại!";
				} // END IF mysqli_affected_rows
			} else {
				$error = "Tất cả các trường đều phải được nhập đầy đủ!";
			}
		} // END main IF submit condition

	}else {
	// Neu nid khong ton tai, redirect nguoi dung ve trang admin
        redirect_to('admin/view_games.php');
    }
    
	include('../includes/backend/header-admin.php');
?>

<!-- Script ################## -->
	<div class="content-wrapper">
        <div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Manage Games</h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 47.25px">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2>Edit Games</h2>
                            <h4><a href="index.php">Home</a> / <a href="view_games.php">List Games</a></h4>
                        </div> <!-- END PANEL HEADING--> 
						<?php 
							if (!empty($messages)) {
								echo " <div class='alert alert-warning' style='font-size: 18px; margin: 25px 35px'>
											<p>{$messages}</p>
                                            
            							</div>";
							}
							if(!empty($success)) {
								echo " <div class='alert alert-success' style='font-size: 18px; margin: 25px 35px'>
											<p>{$success}</p>
            							</div>";
            				}
            				if(!empty($fail)) {
								echo " <div class='alert alert-warning' style='font-size: 18px; margin: 25px 35px'>
											<p>{$fail}</p>
            							</div>";
            				}
            				if(!empty($error)) {
								echo " <div class='alert alert-danger' style='font-size: 18px; margin: 25px 35px'>
											<p>{$error}</p>
            							</div>";
            				}
            				?>
     <!-- ================================== Form Add News [start] ===================================== -->      
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="edit_news" action="" method="post" enctype="multipart/form-data"> <!-- BEGIN FORM -->								
								<!-- ================= Title [start] =================== -->
								<div class="form-group"  style="font-size: 18px" >
								   	<label for="title">Title</label>
								    <input style="font-size: 18px; height: 44px" type="text" class="form-control" id="title" name="title" size="20" maxlength="150" placeholder="Enter title " value="<?php if(isset($games['title'])) echo $games['title']; ?>"/>
                                <?php 
                                    if (isset($errors) && in_array('title', $errors)) {
                                        echo " <div class='alert alert-warning' style='font-size: 16px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                                    <p>Title không được bỏ trống </p>
                                                </div>";

                                    }
                                ?>
                                </div>
                                
								<!-- ================= Type [start] =================== -->
				     			<div class="form-group" style="font-size: 18px">
				                    <label>Select Type</label>
				                    
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
				                    <?php 
										if (isset($errors) && in_array('type', $errors)) {
												echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
														<p>Type không được bỏ trống</p>
	                    							</div>";
										}
									?>
				                </div>  
                                
								<!-- ================= Avatar [start] ===================== -->
								<div class="form-group" style="font-size: 18px">
								    <label for="image">Images Input</label> <br>
								    <img id="avatar" style="width: 300px; height: 300px;" />
                                    <input  name="myAvatar"  style="margin-top: 15px" id="uploadAvatar" type="file" onchange="PreviewBanner();" value="<?php if(isset($games['image'])) echo $games['image'];  ?>"/>
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
								    <textarea name="content" class="form-control" cols="20" rows="15" style="font-size: 15px" size="20" maxlength="2000" placeholder="Please text some content"><?php if(isset($games['content'])) echo htmlentities($games['content'], ENT_COMPAT, 'UTF-8'); ?></textarea>
								<?php 
                                    if (isset($errors) && in_array('type', $errors)) {
                                            echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                                    <p>Nội dung không được bỏ trống </p>
                                                </div>";
                                    }
                                ?>
								</div>
								
                                <!-- ================= Status: default is 0 [start] ===================== -->
                                <div class="form-group" style="font-size: 18px">
				                    <label>Select Status</label>
				                    <select name="status" class="form-control" style="font-size: 18px; height: 44px">										
				                        <option value="0" <?php if (isset($games['status']) && ($games['status'] == 0 )) echo "selected='selected'"; ?>>Inactive</option>
				                        <option value="1" <?php if (isset($games['status']) && ($games['status'] == 1 )) echo "selected='selected'"; ?>>Active</option>
				                    </select>
				                </div>
                                
								<!-- Update Button -->
								<center >
									<input type="submit" name="submit" class="btn btn-success" style="font-size: 18px; height: 44px; margin-right: 10px"  value="Update">
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
