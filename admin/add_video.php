<!--#####################################################################
    #
    #   File          : ADD VIDEO
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
	include('../includes/backend/mysqli_connect.php');
	include('../includes/functions.php');

    $vid = $_GET['vid'];
    if(empty($vid) || strlen($vid) != 11){
        redirect_to('admin/list_videos.php');
    }else {
        $title_page = 'Add Video';
        $video = get_youtube($vid);
        $title = $video['title'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // create variable error
            $errors = array();
            $uid = $_SESSION['uid'];

            // validate type
            if (isset($_POST['type']) && filter_var($_POST['type'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                $type_id = $_POST['type'];
            }else{
                $errors[] = 'type';
            }

            // validate description
            if (empty($_POST['description'])) {
                $errors[] = "description";
            } else {
                $description = mysqli_real_escape_string($dbc, strip_tags($_POST['description']));
            }

            $url_video = "https://www.youtube.com/watch?v=$vid";
            $url_thumbnail ="http://img.youtube.com/vi/$vid/sddefault.jpg";

            // validate status
            if (isset($_POST['status'])) {
                $status = $_POST['status'];
            }else{
                $errors[] = 'status';
            }

            $thumbnail = save_thumbnail_from_url($url_thumbnail, $vid);
            if (empty($errors)) {

                $result = addVideo($uid, $type_id, $title, $description, $thumbnail, $url_video, $status);

                if (mysqli_affected_rows($dbc) == 1) {
                    echo "<script type='text/javascript'>
                            alert('{$lang['AD_VIDEO_SUCCESS']}');
                            window.location = 'list_videos.php';
                            </script>
                        ";
                } else {
                    echo "<script type='text/javascript'>
                            alert('{$lang['AD_FAIL']}');
                            window.location = 'list_videos.php';
                            </script>
                        ";
                }
            } else {
                $error = $lang['AD_REQUIRED'];
            }
        }
    }
    include('../includes/backend/header-admin.php');
?>
	<div class="content-wrapper">
        <div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['ADD_VIDEO_PAGE_HEADER']?></h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 4.1%">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2><?= $lang['ADD_VIDEO_H2']?></h2>
                            <h4><a href="index.php"><?= $lang['ADD_VIDEO_LINK_HOME']?></a> / <a href="list_videos.php"><?= $lang['ADD_VIDEO_LINK_LIST']?></a></h4>
                        </div> <!-- END PANEL HEADING-->
                        <?php if(!empty($error)) : ?>
                            <div class='message-error alert alert-danger'>
                                <p><?= $error?></p>
                            </div>
            			<?php endif; ?>
    <!-- ================================== Form Add Images [start] ===================================== -->
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="add_videos" action="" method="post" >

                                <!-- ================= Title [start] =================== -->
								<div class="label-fontsize form-group">
								   	<label for="title"><?= $lang['ADD_VIDEO_FORM_TITLE_LABEL'] ?></label>
                                    <input style="height: 44px" type="text" class="label-fontsize form-control" id="title" name="title" placeholder="<?= $lang['ADD_VIDEO_FORM_TITLE_TEXT']?> " value="<?= $video['title'] ?>"/>
								</div>

								<!-- ================= Type [start] ===================== -->
				     			<div class="label-fontsize form-group" >
				                    <label><?= $lang['ADD_VIDEO_FORM_TYPE']?></label>

				                    <select name="type" class="form-control" style="font-size: 18px; height: 44px">
				                        <option>-------</option>
				                        <?php
											$query = "SELECT type_id, type_name FROM tbltypes WHERE cat_id = 4 ORDER BY type_id ASC";
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
											<p><?= $lang['ADD_VIDEO_FORM_TYPE_REQUIRED'] ?></p>
	                    				</div>
                                    <?php endif; ?>
				                </div>

								<!-- ================= Url_video [start] =================== -->
								<div class="label-fontsize form-group" >
                                    <label for="title"><?= $lang['ADD_VIDEO_FORM_URL']?></label>
                                    <input style="height: 44px" type="text" class="label-fontsize form-control" id="url" name="url" size="20" maxlength="150" value="https://www.youtube.com/watch?v=<?= $vid ?>" disabled/>
								</div>

                                <!-- ================= Description [start] =================== -->
								<div class="label-fontsize form-group" >
                                    <label for="title"><?= $lang['ADD_VIDEO_FORM_DES'] ?></label>
                                    <textarea id="description" name="description" class="form-control" rows="4" style="font-size: 18px" size="20" maxlength="1000" placeholder="<?= $lang['ADD_VIDEO_FORM_DES_TEXT']?>" value="<?php if(isset($description)) echo $description ?>"></textarea>
								<?php if (isset($errors) && in_array('description', $errors)) : ?>
                                    <div class='message alert alert-warning'>
                                        <p><?= $lang['ADD_VIDEO_FORM_DES_REQUIRED']?></p>
                                    </div>
                                <?php endif; ?>
								</div>

                                <!-- ================= Status: default is 0 [start] ===================== -->
                                <div class="label-fontsize form-group" >
				                    <label><?= $lang['ADD_VIDEO_FORM_STATUS']?></label>

				                    <select name="status" class="label-fontsize form-control" style="height: 44px">
				                        <option value="0"><?= $lang['ADD_VIDEO_FORM_STATUS_VAL_0']?></option>
				                        <option value="1"><?= $lang['ADD_VIDEO_FORM_STATUS_VAL_1']?></option>
				                    </select>
				                </div>

								<!-- ================= Submit & Reset Button [start] ===================== -->
								<center >
									<input type="submit" name="submit" class="btncustom btn btn-success" style="margin-right: 5px"  value="<?= $lang['BUTTON_ADD'] ?>">
                                    <input type="reset" class="btncustom btn btn-warning" style="margin-right: 5px" value="<?= $lang['BUTTON_RESET'] ?>">
                                    <input type="button" class="btncustom btn btn-danger" onclick="window.history.back();" value="<?= $lang['BUTTON_BACK'] ?>">
								</center>

							</form> <!-- END FORM ADD VIDEOS-->
						</div>
		          	</div> <!-- END PANEL BODY-->
				</div>
    <!-- ================================== Form Add Videos [end] ===================================== -->
			</div>
		</div>
    </div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>
