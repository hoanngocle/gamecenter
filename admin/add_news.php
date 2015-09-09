<?php 
	include('../includes/backend/header-admin.php');
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');
?>


<?php 
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){ // gia tri ton tai, xu ly form
		//tao bien luu loi
		$errors = array();

		// kiem tra page name co gia tri hay khong
		if (empty($_POST['title'])) {
			$errors[] = "title";
		} else {
			$title = mysqli_real_escape_string($dbc, strip_tags($_POST['title']));
		}

		// kiem tra xem category co gia tri hay ko
		if (isset($_POST['category']) && filter_var($_POST['category'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
			$cat_id = $_POST['category'];
		}else{
			$errors[] = 'category';
		}

		// kiem tra xem type co gia tri hay ko
		if (isset($_POST['type'])) {
			$type = $_POST['type'];
		}else{
			$errors[] = 'type';
		}

		// kiem tra avatar co gia tri hay khong
		if (empty($_FILES['myAvatar']['name'])) {
			$errors[] = "myAvatar";
		} else {
			$myAvatar =  $_FILES['myAvatar']['name'];
		}

		// kiem tra banner co gia tri hay khong
		if (empty($_FILES['myBanner']['name'])) {
			$errors[] = "myBanner";
		} else {
			$myBanner = $_FILES['myBanner']['name'];
		}
		
		// kiem tra position co gia tri hay ko
		if (empty($_POST['content'])) {
			$errors[] = 'content';
		}else {
			$content = mysqli_real_escape_string($dbc, $_POST['content']);
		}

		// kiem tra xem co loi hay khong
		if (empty($errors)) {
			// neu ko co loi xay ra bat dau chen vao CSDL
			$query = "INSERT INTO tblnews ( user_id, cat_id, type, title, avatar, banner, content, post_on)
						VALUES (1, {$cat_id}, '{$type}', '{$title}','{$myAvatar}','{$myBanner}','{$content}', NOW())";			
			$result = mysqli_query($dbc, $query);
			// ham tra ve ket qua co dung hay ko
			confirm_query($result, $query);

			if (mysqli_affected_rows($dbc) == 1) {
				$success = "The news was added successfully!</p>";
			} else {
				$fail = "The page could not be added due to a system error!";
			}
		} else {
			$error = "Please fill in all the required fields";
		}
	} // END main IF submit condition
?>
<!-- Script ################## -->
	<div class="content-wrapper">
        <div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Manage News</h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 47.25px">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2>Add News</h2>
                            <h4><a href="view_news.php">List News</a></h4>
                        </div> <!-- END PANEL HEADING--> 
						<?php 
							if(!empty($messages)) 
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
								echo " <div class='alert alert-error' style='font-size: 18px; margin: 25px 35px'>
											<p>{$error}</p>
            							</div>";
            						}
            				?>
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="add_news" action="" method="post" enctype="multipart/form-data">

								<div class="form-group"  style="font-size: 18px" >
								   	<label for="title">Title</label>
								    <input style="font-size: 18px; height: 44px" type="text" class="form-control" id="title" name="title" placeholder="Enter title " />
								<?php 
										if (isset($errors) && in_array('title', $errors)) {
											echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
														<p>Please fill in the title </p>
	                    							</div>";

										}
									?>
								</div>
								<!-- Title ####################### -->

				     			<div class="form-group" style="font-size: 18px">
				                    <label>Select Category</label>
				                    
				                    <select name="category" class="form-control" style="font-size: 18px; height: 44px">
				                        <option>-------</option>
				                        <?php 
											$query = "SELECT cat_id, cat_name FROM tblcategories ORDER BY cat_id ASC";

											$result = mysqli_query($dbc, $query);
											if(mysqli_num_rows($result) > 0){
												while($cats = mysqli_fetch_array($result, MYSQLI_NUM)){
													echo "<option value='{$cats[0]}'"; 
														if (isset($_POST['category']) && ($_POST['category'] == $cats[0])) echo "selected='selected'";
													echo ">".$cats[1]."</option>";	
												}
											}
										 ?>
				                    </select>
				                    <?php 
										if (isset($errors) && in_array('category', $errors)) {
												echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
														<p>Please fill in the title </p>
	                    							</div>";
										}
									?>
				                </div>
          						<!-- ####################### -->

				                <div class="form-group" style="font-size: 18px">
				                    <label>Select Type</label>

				                    <select name="type" class="form-control" style="font-size: 18px; height: 44px">
				                        <option>-------</option>
				                        <option value="Games">Games</option>
				                        <option value="News">News</option>
				                    </select>
				                    <?php 
										if (isset($errors) && in_array('type', $errors)) {
												echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
														<p>Please fill in the title </p>
	                    							</div>";
										}
									?>
				                </div>
								<!-- Avatar ####################### -->
								<div class="form-group" style="font-size: 18px">
								    <label for="image">Images Input</label> <br>
								    <img id="avatar" style="width: 300px; height: 300px;" />
									<input  name="myAvatar"  style="margin-top: 15px" id="uploadAvatar" type="file" onchange="PreviewAvatar();" />
								</div>
<?php 
										if (isset($errors) && in_array('myAvatar', $errors)) {
											echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
														<p>Please fill in the title </p>
	                    							</div>";

										}
									?>
								<!-- Banner ####################### -->

								<div class="form-group" style="font-size: 18px">
				                    <label for="banner">Banner Input</label> <br>
				                    <img id="banner" style="width: 800px; height: 200px;" />
									<input name="myBanner" style="margin-top: 15px" id="uploadBanner" type="file" onchange="PreviewBanner();" />
					            </div>	

								<?php 
										if (isset($errors) && in_array('myBanner', $errors)) {
											echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
														<p>Please fill in the title </p>
	                    							</div>";

										}
									?>
								<!-- Content ####################### -->
								<div class="form-group" style="font-size: 18px">
								   	<label for="content">Content</label>
								    <textarea name="content" class="form-control" rows="9" style="font-size: 15px" placeholder="Please text some content"></textarea>
								<?php 
										if (isset($errors) && in_array('title', $errors)) {
												echo " <div class='alert alert-warning' style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>
														<p>Please fill in the title </p>
	                    							</div>";
										}
									?>
								</div>

								<!-- Submit & Reset Button -->
								<center >
									<input type="submit" name="submit" class="btn btn-success" style="font-size: 18px; height: 44px; margin-right: 10px"  value="Submit">
									<button type="reset" class="btn btn-danger" style="font-size: 18px; height: 44px">Reset</button>
								</center>							
							</form> <!-- END FORM ADD NEWS-->				 
						</div> 
		          	</div> <!-- END PANEL BODY-->
				</div>

<!-- =################################################################################################################### -->			

			</div>
		</div> <!-- END ROWS -->
    </div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>
