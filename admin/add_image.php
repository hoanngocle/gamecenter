<!--#####################################################################
    #
    #   File          : ADD IMAGE
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
	include('../includes/backend/mysqli_connect.php');
	include('../includes/functions.php');

    $title_page = 'Add Gallery';
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

		// validate Image
		if (empty($_FILES['myImage']['name'])) {
			$errors[] = "myImage";
		} else {
            $check = checkImage($_FILES['myImage']['name']);
            if(mysqli_num_rows($check) > 0){
                $errors[] = 'existIMG';
            }else {
              $myImage =  $_FILES['myImage']['name'];
            }
		}

        // validate status
        if (isset($_POST['status'])) {
            $status = $_POST['status'];
        }else{
            $errors[] = 'status';
        }

		if (empty($errors)) {
            // upload img
            $targetimg = '../images/uploads/'.$myImage;
            move_uploaded_file($_FILES['myImage']['tmp_name'], $targetimg  );

			$result = addImage($uid, $type_id, $title, $myImage, $status);

			if (mysqli_affected_rows($dbc) == 1) {
                echo "<script type='text/javascript'>
                        alert('{$lang['AD_IMG_SUCCESS']}');
                        window.location = 'list_images.php';
                        </script>
                    ";
            } else {
                echo "<script type='text/javascript'>
                        alert('{$lang['ADD_FAIL']}');
                        window.location = 'list_images.php';
                        </script>
                    ";
            }
		} else {
			$error = $lang['AD_REQUIRED'];
		}
    } // END main IF submit condition
	include('../includes/backend/header-admin.php');
?>
	<div class="content-wrapper">
        <div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['ADD_IMAGE_PAGE_HEADER'] ?></h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 4.1%">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2><?= $lang['ADD_IMAGE_H2'] ?></h2>
                            <h4><a href="index.php"><?= $lang['ADD_IMAGE_LINK_HOME'] ?></a> / <a href="list_images.php"><?= $lang['ADD_IMAGE_LINK_LIST']?></a></h4>
                        </div> <!-- END PANEL HEADING-->
						<?php if(!empty($error)) : ?>
                            <div class='message-error alert alert-danger'>
                                <p><?= $error?></p>
                            </div>
            			<?php endif; ?>
    <!-- ================================== Form Add Images [start] ===================================== -->
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="add_news" action="" method="post" enctype="multipart/form-data">

                                <!-- ================= Title [start] =================== -->
								<div class="label-fontsize form-group" >
								   	<label for="title"><?= $lang['ADD_IMAGE_FORM_TITLE_LABEL']?></label>
                                    <input style="height: 44px" type="text" class="label-fontsize form-control" id="title" name="title" placeholder="<?= $lang['ADD_IMAGE_FORM_TITLE_TEXT']?>  " value="<?php if(isset($title)) : echo $title; endif; ?>" />
								<?php if(isset($errors) && in_array('title', $errors)) : ?>
                                    <div class='message alert alert-warning'>
                                        <p><?= $lang['ADD_IMAGE_FORM_TITLE_REQUIRED'] ?></p>
                                    </div>
                                <?php endif; ?>
								</div>

								<!-- ================= Type [start] ===================== -->
				     			<div class="label-fontsize form-group" >
				                    <label><?= $lang['ADD_IMAGE_FORM_TYPE'] ?></label>

				                    <select name="type" class="label-fontsize form-control" style="height: 44px">
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
				                    <?php if (isset($errors) && in_array('type', $errors)) : ?>
										<div class='message alert alert-warning'>
											<p><?= $lang['ADD_IMAGE_FORM_TYPE_REQUIRED']?></p>
	                    				</div>
                                    <?php endif; ?>
				                </div>

								<!-- ================= Image [start] ===================== -->
								<div class="label-fontsize form-group" >
								    <label for="image"><?= $lang['ADD_IMAGE_FORM_IMG'] ?></label><br>
								    <img id="image" class="image" />
									<input name="myImage"  style="margin-top: 15px" id="uploadImage" type="file" onchange="PreviewImage();" />
                                    <?php if (isset($errors) && in_array('myImage', $errors)) : ?>
										<div class='message alert alert-warning'>
                                            <p><?= $lang['ADD_IMAGE_FORM_IMG_REQUIRED'] ?></p>
                                        </div>
                                    <?php elseif(isset($errors) && in_array('existIMG', $errors)) : ?>
                                        <div class='message alert alert-warning'>
                                            <p><?= $lang['ADD_IMAGE_FORM_IMG_EXIST'] ?></p>
                                        </div>
                                    <?php endif; ?>
								</div>

                                <!-- ================= Status: default is 0 [start] ===================== -->
                                <div class="label-fontsize form-group" >
				                    <label><?= $lang['ADD_IMAGE_FORM_STATUS']?></label>

				                    <select name="status" class="label-fontsize form-control" style="height: 44px">
				                        <option value="0"><?= $lang['ADD_IMAGE_FORM_STATUS_VAL_0']?></option>
				                        <option value="1"><?= $lang['ADD_IMAGE_FORM_STATUS_VAL_1']?></option>
				                    </select>
				                </div>

								<!-- ================= Submit, Reset & Back Button [start] ===================== -->
								<center >
									<input type="submit" name="submit" class="btncustom btn btn-success" style="margin-right: 5px"  value="<?= $lang['BUTTON_ADD'] ?>">
                                    <input type="reset" class="btncustom btn btn-warning" style="margin-right: 5px" value="<?= $lang['BUTTON_RESET'] ?>">
                                    <input type="button" class="btncustom btn btn-danger" onclick="window.history.back();" value="<?= $lang['BUTTON_BACK'] ?>">
								</center>
							</form> <!-- END FORM ADD VIDEO-->
						</div>
		          	</div> <!-- END PANEL BODY-->
				</div>
    <!-- ================================== FORM ADD VIDEO [end] ===================================== -->
			</div>
		</div> >
    </div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>
