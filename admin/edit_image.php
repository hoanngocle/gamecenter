<!--#####################################################################
    #
    #   File          : EDIT IMAGE
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
	include('../includes/backend/mysqli_connect.php');
	include('../includes/functions.php');

    $title_page = 'Edit Gallery';
	if ( $iid = validate_id($_GET['iid'])) {
        $result = get_image_item($iid);

        if (mysqli_num_rows($result) == 1) {
            $news = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }else {
            redirect_to('admin/list_images.php');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = array();

            //validate title
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

            // validate status
            if (isset($_POST['status'])) {
                $status = $_POST['status'];
            }else{
                $errors[] = 'status';
            }

            if (empty($errors)) {
                $result = edit_image($iid, $title, $type_id, $status);

                if (mysqli_affected_rows($dbc) == 1) {
					echo "<script type='text/javascript'>
                            alert('{$lang['AD_EDIT_IMG_SUCCESS']}');
                            window.location = 'list_images.php';
                            </script>
                        ";
				} else {
                    echo "<script type='text/javascript'>
                            alert('{$lang['AD_EDIT_FAIL']}');
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
	<div class="content-wrapper">
        <div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['ADD_IMAGE_PAGE_HEADER']?></h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 4.1%">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2><?= $lang['EDIT_IMAGE_H2'] ?></h2>
                            <h4><a href="index.php"><?= $lang['ADD_IMAGE_LINK_HOME']?></a> / <a href="list_images.php"><?= $lang['ADD_IMAGE_LINK_LIST']?></a></h4>
                        </div> <!-- END PANEL HEADING-->
						<?php if(!empty($error)) : ?>
                            <div class='message-error alert alert-danger'>
                                <p><?= $error?></p>
                            </div>
            			<?php endif; ?>
     <!-- ================================== FORM EDIT GAME [start] ===================================== -->
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="add_news" action="" method="post" enctype="multipart/form-data">
                            <!-- ================= Title [start] =================== -->
								<div class="label-fontsize form-group">
								   	<label for="title"><?= $lang['ADD_IMAGE_FORM_TITLE_LABEL']?></label>
								    <input style="height: 44px" type="text" class="label-fontsize form-control" id="title" name="title" placeholder="<?= $lang['ADD_IMAGE_FORM_TITLE_TEXT']?>" />
								<?php if(isset($errors) && in_array('title', $errors)) : ?>
                                    <div class='message alert alert-warning'>
                                        <p><?= $lang['ADD_IMAGE_FORM_TITLE_REQUIRED'] ?></p>
                                    </div>
                                <?php endif; ?>
								</div>

                                <!-- ================= Type [start] =================== -->
				     			<div class="label-fontsize form-group">
				                    <label><?= $lang['ADD_IMAGE_FORM_TYPE']?></label>

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
											<p><?= $lang['ADD_IMAGE_FORM_TYPE_REQUIRED']?></p>
	                    				</div>
                                    <?php endif; ?>
				                </div>

								<!-- Submit & Reset Button -->
								<center >
									<input type="submit" name="submit" class="btncustom btn btn-success" value="<?= $lang['BUTTON_UPDATE']?>">
                                    <input type="reset" class="btncustom btn btn-warning" value="<?= $lang['BUTTON_RESET'] ?>">
                                    <input type="button" class="btncustom btn btn-danger" onclick="window.history.back();" value="<?= $lang['BUTTON_BACK'] ?>">
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