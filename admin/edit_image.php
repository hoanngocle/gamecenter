<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');
?>

<?php 
    $title_page = 'Edit Gallery';
	if ( $iid = validate_id($_GET['iid'])) {
		
        // Chon image trong CSDL de hien thi ra trinh duyet
        $query = "SELECT * FROM tblimages WHERE image_id = {$iid}";
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        if (mysqli_num_rows($result) == 1) {
            $news = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }else {
            $messages = "Ảnh không tồn tại!";
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // tao bien luu loi
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
                $result = edit_image($iid, $title, $type_id, $myImage, $status);
                $result = mysqli_query($dbc, $query);
                // ham tra ve ket qua co dung hay ko
                confirm_query($result, $query);

                if (mysqli_affected_rows($dbc) == 1) {
					echo "<script type='text/javascript'>
                            alert('{$lang['EDIT_OK']}');
                            window.location = 'list_images.php';
                            </script>      
                        ";
				} else {
                    echo "<script type='text/javascript'>
                            alert('{$lang['EDIT_FAIL']}');
                            window.location = 'list_images.php';
                            </script>      
                        ";
				}
            } else {
                $error = $lang['AD_REQUIRED'];
            }
        } // END main IF submit condition
    }else {
        redirect_to('admin/list_images.php');
    }
    include('../includes/backend/header-admin.php');
?>
<!-- Script ################## -->
	<div class="content-wrapper">
        <div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['Manage Images']?></h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 47.25px">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2><?= $lang['Edit Image']?></h2>
                            <h4><a href="index.php"><?= $lang['Home']?></a> / <a href="list_images.php"><?= $lang['List Images']?></a></h4>
                        </div> <!-- END PANEL HEADING--> 
						<?php if(!empty($error)) : ?>
                            <div class='alert alert-danger' style='font-size: 18px; margin: 25px 35px'>
                                <p><?= $error?></p>
                            </div>
            			<?php endif; ?>
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="add_news" action="" method="post" enctype="multipart/form-data">

								<div class="form-group"  style="font-size: 18px" >
								   	<label for="title">Title</label>
								    <input style="font-size: 18px; height: 44px" type="text" class="form-control" id="title" name="title" placeholder="Enter title " />
								<?php if(isset($errors) && in_array('title', $errors)) : ?>
                                    <div class='alert alert-warning' style='font-size: 16px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                        <p><?= $lang['AD_Title_required'] ?></p>
                                    </div>
                                <?php endif; ?>
								</div>
								<!-- Title ####################### -->

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

								<!-- Avatar ####################### -->
								<div class="form-group" style="font-size: 18px">
								    <label for="image"><?= $lang['Images Input'] ?></label> <br>
								    <img id="image" style="width: 300px; height: 300px;" />
									<input  name="myImage"  style="margin-top: 15px" id="uploadImage" type="file" onchange="PreviewImage();" />
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