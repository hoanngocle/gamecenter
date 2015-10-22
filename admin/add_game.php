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
				redirect_to('admin/view_game.php');
			} else {
				redirect_to('admin/view_game.php');
			}
		} else {
			$error = "Tất cả các trường đều phải được nhập đầy đủ!";
		}
	} // END main IF submit condition
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
                            <h2>Add Games</h2>
                            <h4><a href="index.php">Home</a> / <a href="view_news.php">List Games</a></h4>
                        </div> <!-- END PANEL HEADING--> 
						<?php 
							if(!empty($success)) {
								echo "<div class='alert alert-success' style='font-size: 18px; margin: 25px 35px'>
											<p>{$success}</p>
            							</div>";
            						}
            				if(!empty($fail)) {
								echo "<div class='alert alert-danger' style='font-size: 18px; margin: 25px 35px'>
											<p>{$fail}</p>
            							</div>";
            						}
            				if(!empty($error)) {
								echo "<div class='alert alert-danger' style='font-size: 18px; margin: 25px 35px'>
											<p>{$error}</p>
            							</div>";
            						}
            				?>
    <!-- ================================== Form Add Games [start] ===================================== -->
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="add_news" action="" method="post" enctype="multipart/form-data">
                                <!-- ================= Title [start] =================== -->
								<div class="form-group"  style="font-size: 18px" >
                                    <label for="title">Title</label>
                                    <input style="font-size: 18px; height: 44px" type="text" class="form-control" id="title" name="title" size="20" maxlength="150" placeholder="Enter title " value="<?php if(isset($title)) echo $title ?>"/>
								<?php 
                                    if (isset($errors) && in_array('title', $errors)) {
                                        echo " <div class='alert alert-warning' style='font-size: 16px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                                    <p>Title không được để trống </p>
                                                </div>";
                                    }
                                ?>
								</div>
                                
								<!-- ================= Type [start] ===================== -->
				     			<div class="form-group" style="font-size: 18px">
				                    <label>Select Type</label>
				                    
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
				                    <?php 
										if (isset($errors) && in_array('type', $errors)) {
												echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
														<p>Type không được để trống</p>
	                    							</div>";
										}
									?>
				                </div>

								<!-- ================= Avatar [start] ===================== -->
								<div class="form-group" style="font-size: 18px">
								    <label for="image">Images Input</label> <br>
								    <img id="avatar" style="width: 300px; height: 300px;" />
                                    <input  name="myAvatar"  style="margin-top: 15px" id="uploadAvatar" type="file" onchange="PreviewAvatar(); " />
								</div>
<?php 
										if (isset($errors) && in_array('myAvatar', $errors)) {
											echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
														<p>Image không được để trống  </p>
	                    							</div>";
										}
									?>
                                
								<!-- ================= Banner [start] ===================== -->
								<div class="form-group" style="font-size: 18px">
				                    <label for="banner">Banner Input</label> <br>
				                    <img id="banner" style="width: 800px; height: 200px;" />
									<input name="myBanner" style="margin-top: 15px" id="uploadBanner" type="file" onchange="PreviewBanner();" />
					            </div>	

								<?php 
										if (isset($errors) && in_array('myBanner', $errors)) {
											echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
														<p>Banner không được để trống </p>
	                    							</div>";
										}
									?>
      
								<!-- ================= Content [start] ===================== -->
								<div class="form-group" style="font-size: 18px">
								   	<label for="content">Content</label>
								    <textarea id="content" name="content" class="form-control" rows="15" style="font-size: 15px" size="20" maxlength="2000" placeholder="Please text some content" value="<?php if(isset($content)) echo $content ?>"></textarea>
                                    <script>CKEDITOR.replace('content'); </script>
								<?php 
										if (isset($errors) && in_array('title', $errors)) {
												echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
														<p>Nội dung không được để trống </p>
	                    							</div>";
										}
									?>
								</div>
                                
                                <!-- ================= Status: default is 0 [start] ===================== -->
                                <div class="form-group" style="font-size: 18px">
				                    <label>Select Status</label>

				                    <select name="status" class="form-control" style="font-size: 18px; height: 44px">
				                        <option value="0">Inactive</option>
				                        <option value="1">Active</option>
				                    </select>
				                </div>
                                
                                <!-- ================= Submit & Reset Button [start] ===================== -->
								<center >
									<input type="submit" name="submit" class="btn btn-success" style="font-size: 18px; height: 44px; margin-right: 10px"  value="Submit">
									<button type="reset" class="btn btn-danger" style="font-size: 18px; height: 44px">Reset</button>
								</center>							
							</form> <!-- END FORM ADD NEWS-->				 
						</div> 
		          	</div> <!-- END PANEL BODY-->
				</div>
                
    <!-- ================================== Form Add News [end] ===================================== -->		
			</div>
		</div> <!-- END ROWS -->
    </div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>
