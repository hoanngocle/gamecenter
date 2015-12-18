<!--#####################################################################
    #
    #   File          : EDIT TAG
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
	include('../includes/backend/mysqli_connect.php');
	include('../includes/functions.php');

    $title_page = 'Edit Game';
	if( $tid = validate_id($_GET['tid'])){

        $result = get_tag_item($tid);
        if (mysqli_num_rows($result) == 1) {
            $tag = mysqli_fetch_array($result, MYSQLI_ASSOC);
        } else {
            redirect_to('admin/list_tag.php');
        }

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$errors = array();

            // validate tag
			if (empty($_POST['tag'])) {
				$errors[] = "tag";
			} else {
				$tag = mysqli_real_escape_string($dbc, strip_tags($_POST['tag']));
			}

			if (empty($errors)) {
				$result = edit_tag($tid, $tag);
				if (mysqli_affected_rows($dbc) == 1) {
					echo "<script type='text/javascript'>
                            alert('{$lang['AD_EDIT_GAME_SUCCESS']}');
                            window.location = 'list_tag.php';
                            </script>
                        ";
				} else {
                    echo "<script type='text/javascript'>
                            alert('{$lang['AD_EDIT_FAIL']}');
                            window.location = 'list_tag.php';
                            </script>
                        ";
				}
			} else {
				$error = $lang['AD_REQUIRED'];
			}
		} // END main IF submit condition

	}else {
        redirect_to('admin/list_tag.php');
    }
	include('../includes/backend/header-admin.php');
?>
	<div class="content-wrapper">
        <div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['ADD_TAG_PAGE_HEADER']?></h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 4.1%">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2><?= $lang['ADD_TAG_H2'] ?></h2>
                            <h4><a href="index.php"><?= $lang['ADD_TAG_LINK_HOME']?></a> / <a href="list_tag.php"><?= $lang['ADD_TAG_LINK_LIST']?></a></h4>
                        </div> <!-- END PANEL HEADING-->
						<?php if(!empty($error)) : ?>
                            <div class='message-error alert alert-danger'>
                                <p><?= $error?></p>
                            </div>
            			<?php endif; ?>
     <!-- ================================== FORM EDIT TAG [start] ===================================== -->
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="edit_news" action="" method="post" enctype="multipart/form-data">

                                <!-- ================= Tag [start] =================== -->
								<div class="label-fontsize form-group" >
								   	<label for="title"><?= $lang['ADD_TAG_FORM_TAG_LABEL'] ?></label>
								    <input style="height: 44px" type="text" class="label-fontsize form-control" id="tag" name="tag" size="20" maxlength="150" placeholder="<?= $lang['ADD_TAG_FORM_TAG_TEXT']?>" value="<?php if(isset($tag['keyword'])) echo $tag['keyword']; ?>"/>
                                <?php if(isset($errors) && in_array('title', $errors)) : ?>
                                    <div class='message alert alert-warning'>
                                        <p><?= $lang['ADD_TAG_FORM_TAG_REQUIRED'] ?></p>
                                    </div>
                                <?php endif; ?>
								</div>

								<!-- Button -->
								<center >
									<input type="submit" name="submit" class="btncustom btn btn-success" value="<?= $lang['BUTTON_UPDATE']?>">
                                    <input type="reset" class="btncustom btn btn-warning" value="<?= $lang['BUTTON_RESET'] ?>">
                                    <input type="button" class="btncustom btn btn-danger" onclick="window.history.back();" value="<?= $lang['BUTTON_BACK'] ?>">
								</center>
							</form> <!-- END FORM EDIT GAME-->
                        </div>
		          	</div> <!-- END PANEL BODY-->
				</div>
			</div>
		</div> <!-- END ROWS -->
    </div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>
