<!--#####################################################################
    #
    #   File          : EDIT VIDEO
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
	include('../includes/backend/mysqli_connect.php');
	include('../includes/functions.php');
    include('../includes/errors.php');

    $title_page = 'Edit Video';

	if( $vid = validate_id($_GET['vid'])){
        $result = get_video_item($vid);

        if (mysqli_num_rows($result) == 1) {
            $videos = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }else {
            redirect_to('admin/list_videos.php');
        }

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$errors = array();

            //validate title
			if (empty($_POST['title'])) {
				$errors[] = "title";
			} else {
				$title = mysqli_real_escape_string($dbc, strip_tags($_POST['title']));
			}

            //validate description
			if (empty($_POST['description'])) {
				$errors[] = 'description';
			}else {
				$description = mysqli_real_escape_string($dbc, $_POST['description']);
			}

			// validate type
            if (isset($_POST['type_id']) && filter_var($_POST['type_id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                $type_id = $_POST['type_id'];
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
				$result = edit_video($vid, $type_id, $title, $description, $status);
				if (mysqli_affected_rows($dbc) == 1) {
					echo "<script type='text/javascript'>
                            alert('{$lang['AD_EDIT_VIDEO_SUCCESS']}');
                            window.location = 'list_news.php';
                            </script>
                        ";
				} else {
                    echo "<script type='text/javascript'>
                            alert('{$lang['AD_EDIT_FAIL']}');
                            window.location = 'list_news.php';
                            </script>
                        ";
				}
			} else {
				$error = $lang['AD_REQUIRED'];
			}
		} // END main IF submit condition

	}else {
        redirect_to('admin/list_videos.php');
    }
	include('../includes/backend/header-admin.php');
?>
	<div class="content-wrapper">
        <div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['ADD_VIDEO_PAGE_HEADER']  ?></h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 4.1%">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2><?= $lang['EDIT_VIDEO_H2'] ?></h2>
                            <h4><a href="index.php"><?= $lang['ADD_VIDEO_LINK_HOME'] ?></a> / <a href="list_videos.php"><?= $lang['ADD_VIDEO_LINK_LIST'] ?></a></h4>
                        </div> <!-- END PANEL HEADING-->
						<?php if(!empty($error)) : ?>
                            <div class='message-error alert alert-danger'>
                                <p><?= $error?></p>
                            </div>
            			<?php endif; ?>
     <!-- ================================== Form Add News [start] ===================================== -->
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="edit_news" action="" method="post" enctype="multipart/form-data"> <!-- BEGIN FORM -->
								<!-- ================= Title [start] =================== -->
								<div class="label-fontsize form-group" >
								   	<label for="title"><?= $lang['ADD_VIDEO_FORM_TITLE_LABEL']?></label>
								    <input style="height: 44px" type="text" class="label-fontsize form-control" id="title" name="title" size="20" maxlength="150" placeholder="<?= $lang['ADD_VIDEO_FORM_TITLE_TEXT']?>" value="<?php if(isset($videos['title'])) echo $videos['title']; ?>"/>
                                <?php if(isset($errors) && in_array('title', $errors)) : ?>
                                    <div class='message alert alert-warning'>
                                        <p><?= $lang['ADD_VIDEO_FORM_TITLE_REQUIRED'] ?></p>
                                    </div>
                                <?php endif; ?>
                                </div>

								<!-- ================= Type [start] =================== -->
				     			<div class="label-fontsize form-group" >
				                    <label><?= $lang['ADD_VIDEO_FORM_TYPE'] ?></label>

				                    <select name="type_id" class="label-fontsize form-control" style=" height: 44px">
				                        <option>-------</option>
				                        <?php
											$query = "SELECT type_id, type_name FROM tbltypes WHERE cat_id = 4 ORDER BY type_id ASC";
											$result = mysqli_query($dbc, $query);
											if(mysqli_num_rows($result) > 0){
												while($types = mysqli_fetch_array($result, MYSQLI_NUM)){
													echo "<option value='{$types[0]}'";
														if (isset($videos['type_id']) && ($videos['type_id'] == $types[0])) echo "selected='selected'";
													echo ">".$types[1]."</option>";
												}
											}
										 ?>
				                    </select>
				                    <?php if (isset($errors) && in_array('type', $errors)) : ?>
										<div class='message alert alert-warning'>
											<p><?= $lang['ADD_NEWS_FORM_TYPE_REQUIRED'] ?></p>
	                    				</div>
                                    <?php endif; ?>
				                </div>

                                <!-- ================= Description [start] =================== -->
								<div class="label-fontsize form-group" >
                                    <label for="title"><?= $lang['ADD_VIDEO_FORM_DES'] ?></label>
                                    <textarea id="description" name="description" class="form-control" rows="4" style="font-size: 18px" size="20" maxlength="1000" placeholder="<?= $lang['ADD_VIDEO_FORM_DES_TEXT']?>" value="<?php if(isset($description)) echo $description ?>"><?php if(isset($videos['description'])) echo $videos['description']; ?></textarea>
                                <?php if (isset($errors) && in_array('description', $errors)) : ?>
										<div class='message alert alert-warning'>
											<p><?= $lang['ADD_VIDEO_FORM_DES_REQUIRED'] ?></p>
	                    				</div>
                                    <?php endif; ?>
                                </div>

                                <!-- ================= Status: default is 0 [start] ===================== -->
                                <div class="label-fontsize form-group">
				                    <label><?= $lang['ADD_VIDEO_FORM_STATUS'] ?></label>
				                    <select name="status" class="label-fontsize form-control" style=" height: 44px">
				                        <option value="0" <?php if (isset($videos['status']) && ($videos['status'] == 0 )) echo "selected='selected'"; ?>><?= $lang['ADD_VIDEO_FORM_STATUS_VAL_0'] ?></option>
				                        <option value="1" <?php if (isset($videos['status']) && ($videos['status'] == 1 )) echo "selected='selected'"; ?>><?= $lang['ADD_VIDEO_FORM_STATUS_VAL_1']?></option>
				                    </select>
				                </div>

								<!-- Update Button -->
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
