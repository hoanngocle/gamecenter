<!--#####################################################################
    #
    #   File          : ADD TYPE
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
	include('../includes/backend/mysqli_connect.php');
	include('../includes/functions.php');

    $title_page = 'Add Type';
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		// create variable error
		$errors = array();
		$uid = $_SESSION['uid'];

		// validate type
		if (empty($_POST['type'])) {
			$errors[] = "type";
		} else {
			$type = mysqli_real_escape_string($dbc, strip_tags($_POST['type']));
		}

		// validate type
		if (isset($_POST['cat']) && filter_var($_POST['cat'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
			$cat = $_POST['cat'];
		}else{
			$errors[] = 'cat';
		}


		if (empty($errors)) {

            // add record
            $result = addType($type, $cat);

			if (mysqli_affected_rows($dbc) == 1) {
                echo "<script type='text/javascript'>
                        alert('{$lang['AD_GAME_SUCCESS']}');
                        window.location = 'list_type.php';
                        </script>
                    ";
            } else {
                echo "<script type='text/javascript'>
                        alert('{$lang['AD_FAIL']}');
                        window.location = 'list_type.php';
                        </script>
                    ";
            }
		} else {
			$error = $lang['AD_REQUIRED'];
		}
	} // END main IF submit condition
    include('../includes/backend/header-admin.php');
?>
<!-- Script ################## -->
	<div class="content-wrapper">
        <div class="container">
    		<div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['ADD_TYPE_PAGE_HEADER']?></h1>
                </div>
        	</div>

        	<div class="row">
                <div class="col-md-11" style="margin-left: 4.1%">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center">
                            <h2><?= $lang['ADD_TYPE_H2'] ?></h2>
                            <h4><a href="index.php"><?= $lang['ADD_TYPE_LINK_HOME'] ?></a> / <a href="list_games.php"><?= $lang['ADD_TYPE_LINK_LIST']?></a></h4>
                        </div> <!-- END PANEL HEADING-->
						<?php if(!empty($error)) : ?>
                            <div class='message-error alert alert-danger' >
                                <p><?= $error?></p>
                            </div>
            			<?php endif; ?>
    <!-- ================================== Form Add Games [start] ===================================== -->
                   		<div class="panel-body" style="margin: 0 20px 0 20px">
							<form id="add_games" action="" method="post" enctype="multipart/form-data">

                                <!-- ================= Title [start] =================== -->
								<div class="label-fontsize form-group"  >
                                    <label for="type"><?= $lang['ADD_TYPE_FORM_TYPE_LABEL']?></label>
                                    <input style="height: 44px" type="text" class="label-fontsize form-control" id="type" name="type" size="20" maxlength="150" placeholder="<?= $lang['ADD_GAME_FORM_TITLE_TEXT'] ?>" value="<?php if(isset($type)) : echo $type; endif; ?>"/>
                                    <?php if(isset($errors) && in_array('type', $errors)) : ?>
                                        <div class='message alert alert-warning' >
                                            <p><?= $lang['ADD_TYPE_FORM_TYPE_REQUIRED'] ?></p>
                                        </div>
                                    <?php endif; ?>
								</div>

								<!-- ================= Type [start] ===================== -->
				     			<div class="label-fontsize form-group">
				                    <label for="title"><?= $lang['ADD_TYPE_FORM_CAT']?></label>

				                    <select name="cat" class="label-fontsize form-control" style=" height: 44px">
				                        <option>-------</option>
				                        <?php
											$query = "SELECT cat_id, cat_name FROM tblcategories";
											$result = mysqli_query($dbc, $query);
											if(mysqli_num_rows($result) > 0){
												while($cat = mysqli_fetch_array($result, MYSQLI_NUM)){
													echo "<option value='{$cat[0]}'";
														if (isset($_POST['type']) && ($_POST['type'] == $cat[0])) echo "selected='selected'";
													echo ">".$cat[1]."</option>";
												}
											}
										?>
				                    </select>
				                    <?php if (isset($errors) && in_array('cat', $errors)) : ?>
										<div class='message alert alert-warning'>
											<p><?= $lang['ADD_TYPE_FORM_CAT_REQUIRED'] ?></p>
	                    				</div>
                                    <?php endif; ?>
				                </div>

                                <!-- ================= Submit & Reset Button [start] ===================== -->
								<center >
									<input type="submit" name="submit" class="btncustom btn btn-success" style="margin-right: 5px"  value="<?= $lang['BUTTON_ADD'] ?>">
                                    <input type="reset" class="btncustom btn btn-warning" style="margin-right: 5px" value="<?= $lang['BUTTON_RESET'] ?>">
                                    <input type="button" class="btncustom btn btn-danger" onclick="window.history.back();" value="<?= $lang['BUTTON_BACK'] ?>">
								</center>
							</form> <!-- END FORM ADD GAMES-->
						</div>
					</div> <!-- END PANEL BODY-->
				</div>
    <!-- ================================== Form Add GAME [end] ===================================== -->
			</div>
		</div>
    </div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>
