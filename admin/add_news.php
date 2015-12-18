<!--#####################################################################
    #
    #   File          : ADD NEW
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
	include('../includes/backend/mysqli_connect.php');
	include('../includes/functions.php');

    $title_page = 'Add News';
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
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
		}  else if(($_FILES['myAvatar']['type'] == 'image/jpeg') || ($_FILES['myAvatar']['type'] == 'image/png') || ($_FILES['myAvatar']['type'] == 'image/bmp')){
			$myAvatar =  $_FILES['myAvatar']['name'];
		}else {
			$errors[] = "errorimg_type";
		}

		// validate Banner
		if (empty($_FILES['myBanner']['name'])) {
			$errors[] = "myBanner";
		} else if(($_FILES['myBanner']['type'] == 'image/jpeg') || ($_FILES['myBanner']['type'] == 'image/png') || ($_FILES['myBanner']['type'] == 'image/bmp')){
			$myBanner = $_FILES['myBanner']['name'];
		} else {
            $errors[] = "errorbanner_type";
		}

		// validate content
		if (empty($_POST['content'])) {
			$errors[] = 'content';
		}else {
			$content = mysqli_real_escape_string($dbc, $_POST['content']);
		}

        // validate status
        if (isset($_POST['status'])) {
            $status = $_POST['status'];
        }else{
            $errors[] = 'status';
        }

		if (empty($errors)) {
            $targetava = '../images/news/'.$myAvatar;
            $targetbanner = '../images/news/'.$myBanner;

            move_uploaded_file($_FILES['myAvatar']['tmp_name'], $targetava  );
            move_uploaded_file($_FILES['myBanner']['tmp_name'], $targetbanner  );
            // add record
			$result = addNews($uid, $type_id, $title, $myAvatar, $myBanner, $content, $status);

			if (mysqli_affected_rows($dbc) == 1) {
                echo "<script type='text/javascript'>
                        alert('{$lang['AD_NEWS_SUCCESS']}');
                        window.location = 'list_news.php';
                        </script>
                    ";
            } else {
                echo "<script type='text/javascript'>
                        alert('{$lang['AD_FAIL']}');
                        window.location = 'list_news.php';
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
                    <h1 class="page-head-line"><?= $lang['ADD_NEWS_PAGE_HEADER'] ?></h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 4.1%">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2><?= $lang['ADD_NEWS_H2'] ?></h2>
                            <h4><a href="index.php"><?= $lang['ADD_NEWS_LINK_HOME'] ?></a> / <a href="list_news.php"><?= $lang['ADD_NEWS_LINK_LIST'] ?></a></h4>
                        </div> <!-- END PANEL HEADING-->
						<?php if(!empty($error)) : ?>
                            <div class='message-error alert alert-danger' >
                                <p><?= $error?></p>
                            </div>
            			<?php endif; ?>
    <!-- ================================== Form Add News [start] ===================================== -->
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="add_news" action="" method="post" enctype="multipart/form-data">

                                <!-- ================= Title [start] =================== -->
								<div class="label-fontsize form-group" >
                                    <label for="title"><?= $lang['Title'] ?></label>
                                    <input style="height: 44px" type="text" class="label-fontsize form-control" id="title" name="title" size="20" maxlength="150" placeholder="<?= $lang['ADD_NEWS_FORM_TITLE_TEXT'] ?> " value="<?php if(isset($title)) : echo $title; endif; ?>"/>
								<?php if(isset($errors) && in_array('title', $errors)) : ?>
                                    <div class='message alert alert-warning'>
                                        <p><?= $lang['ADD_NEWS_FORM_TITLE_REQUIRED']?></p>
                                    </div>
                                <?php endif; ?>
								</div>

								<!-- ================= Type [start] ===================== -->
				     			<div class="label-fontsize form-group" >
				                    <label><?= $lang['ADD_NEWS_FORM_TYPE']?></label>

				                    <select name="type" class="label-fontsize form-control" style="height: 44px">
				                        <option>-------</option>
				                        <?php
											$query = "SELECT type_id, type_name FROM tbltypes WHERE cat_id = 1 ORDER BY type_id ASC";
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
											<p><?= $lang['ADD_NEWS_FORM_TYPE_REQUIRED']?></p>
	                    				</div>
                                    <?php endif; ?>
				                </div>

								<!-- ================= Avatar [start] ===================== -->
								<div class="label-fontsize form-group">
								    <label for="image"><?= $lang['ADD_NEWS_FORM_IMG'] ?></label> <br>
								    <img id="avatar"  class="avatar"/>
                                    <input  name="myAvatar"  style="margin-top: 15px" id="uploadAvatar" type="file" onchange="PreviewAvatar(); " />
								</div>
                                <?php if (isset($errors) && in_array('myAvatar', $errors)) :	?>
                                    <div class='message alert alert-warning'>
                                        <p><?= $lang['ADD_NEWS_FORM_IMG_REQUIRED'] ?></p>
                                    </div>
                                <?php elseif (isset($errors) && in_array('errorimg_type', $errors)) :	?>
                                    <div class='message alert alert-warning'>
                                        <p><?= $lang['ADD_NEWS_FORM_IMG_TYPE'] ?></p>
                                    </div>
                                <?php endif; ?>

								<!-- ================= Banner [start] ===================== -->
								<div class="label-fontsize form-group" >
				                    <label for="banner"><?= $lang['ADD_NEWS_FORM_BANNER']  ?></label> <br>
				                    <img id="banner" class="banner"/>
									<input name="myBanner" style="margin-top: 15px" id="uploadBanner" type="file" onchange="PreviewBanner();" />
					            </div>
								<?php if (isset($errors) && in_array('myBanner', $errors)) : ?>
									<div class='message alert alert-warning'>
                                        <p><?= $lang['ADD_NEWS_FORM_BANNER_REQUIRED']?></p>
                                    </div>
                                <?php elseif (isset($errors) && in_array('errorbanner_type', $errors)) :	?>
                                    <div class='message alert alert-warning'>
                                        <p><?= $lang['ADD_NEWS_FORM_IMG_TYPE'] ?></p>
                                    </div>
                                <?php endif; ?>

								<!-- ================= Content [start] ===================== -->
								<div class="label-fontsize form-group">
								   	<label for="content"><?= $lang['ADD_NEWS_FORM_CONTENT'] ?></label>
								    <textarea id="content" name="content" class="form-control" rows="9" style="font-size: 15px" size="20" maxlength="2000" placeholder="<?= $lang['ADD_NEWS_FORM_CONTENT_TEXT'] ?> " value="<?php if(isset($content)) : echo $content; endif; ?>"></textarea>
                                    <script>CKEDITOR.replace('content'); </script>
								<?php if (isset($errors) && in_array('content', $errors)) : ?>
                                    <div class='message alert alert-warning' >
                                        <p><?= $lang['ADD_NEWS_FORM_CONTENT_REQUIRED'] ?></p>
                                    </div>
                                <?php endif; ?>
								</div>

                                <!-- ================= Status: default is 0 [start] ===================== -->
                                <div class="label-fontsize form-group">
				                    <label><?= $lang['ADD_NEWS_FORM_STATUS']?></label>

				                    <select name="status" class="label-fontsize form-control" style="height: 44px">
				                        <option value="0"><?= $lang['ADD_NEWS_FORM_STATUS_VAL_0']?></option>
				                        <option value="1"><?= $lang['ADD_NEWS_FORM_STATUS_VAL_1']?></option>
				                    </select>
				                </div>

                                <!-- ================= Submit & Reset Button [start] ===================== -->
								<center >
									<input type="submit" name="submit" class="btncustom btn btn-success" style="margin-right: 5px"  value="<?= $lang['BUTTON_ADD'] ?>">
                                    <input type="reset" class="btncustom btn btn-warning" style="margin-right: 5px" value="<?= $lang['BUTTON_RESET'] ?>">
                                    <input type="button" class="btncustom btn btn-danger" onclick="window.history.back();" value="<?= $lang['BUTTON_BACK'] ?>">
								</center>
							</form> <!-- END FORM ADD NEWS-->
						</div>
		          	</div> <!-- END PANEL BODY-->
				</div>

    <!-- ================================== Form Add News [end] ===================================== -->
			</div>
		</div>
    </div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>
