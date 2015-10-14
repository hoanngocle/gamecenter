<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');
?>

<?php 
    $title_page = 'Add Gallery';
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){ // gia tri ton tai, xu ly form
		//tao bien luu loi
		$errors = array();

		// kiem tra page name co gia tri hay khong
		if (empty($_POST['title'])) {
			$errors[] = "title";
		} else {
			$title = mysqli_real_escape_string($dbc, strip_tags($_POST['title']));
		}

		// kiem tra xem type co gia tri hay ko
		if (isset($_POST['type']) && filter_var($_POST['type'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
			$type_id = $_POST['type'];
		}else{
			$errors[] = 'type';
		}

		// kiem tra image co gia tri hay khong
		if (empty($_FILES['myImage']['name'])) {
			$errors[] = "myImage";
		} else {
			$myImage =  $_FILES['myImage']['name'];
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
			$query = "INSERT INTO tblimages (user_id, title, type_id, image, status, post_on )
						VALUES (1, '{$title}', {$type_id}, '{$myImage}', '{$status}', NOW())";			
			$result = mysqli_query($dbc, $query);
			// ham tra ve ket qua co dung hay ko
			confirm_query($result, $query);

			if (mysqli_affected_rows($dbc) == 1) {
				$success = "Thêm thành công ảnh vào cơ sở dữ liệu!</p>";
			} else {
				$fail = "Tạo mới ảnh thất bại do lỗi hệ thống!";
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
                    <h1 class="page-head-line">Manage Images</h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 47.25px">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2>Upload Images</h2>
                            <h4><a href="index.php">Home</a> / <a href="view_news.php">List Images</a></h4>
                        </div> <!-- END PANEL HEADING--> 
						<?php 
							if(!empty($success)) {
								echo " <div class='alert alert-success' style='font-size: 18px; margin: 25px 35px'>
											<p>{$success}</p>
            							</div>";
            						}
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
							<form id="add_news" action="" method="post" enctype="multipart/form-data">
                                <!-- ================= Title [start] =================== -->
								<div class="form-group"  style="font-size: 18px" >
								   	<label for="title">Title</label>
                                    <input style="font-size: 18px; height: 44px" type="text" class="form-control" id="title" name="title" placeholder="Enter title " value="<?php if(isset($title)) echo $title ?>" />
								<?php 
                                    if (isset($errors) && in_array('title', $errors)) {
                                        echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                                    <p>Không được để trống title!</p>
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
											$query = "SELECT type_id, type_name FROM tbltypes WHERE cat_id = 3 ORDER BY type_id ASC";
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

								<!-- ================= Image [start] ===================== -->
								<div class="form-group" style="font-size: 18px">
								    <label for="image">Images Input</label> <br>
								    <img id="image" style="width: 300px; height: 300px;" />
									<input  name="myImage"  style="margin-top: 15px" id="uploadImage" type="file" onchange="PreviewImage();" />
								</div>
<?php 
										if (isset($errors) && in_array('myImage', $errors)) {
											echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
														<p>Images không được để trống</p>
	                    							</div>";

										}
									?>
								
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
