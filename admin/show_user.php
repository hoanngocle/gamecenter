<?php
	include('../includes/backend/mysqli_connect.php');
	include('../includes/functions.php');
    include('../includes/errors.php');

	if( $nid = validate_id($_GET['uid'])){
		$set = get_user_by_id_list($nid);

		$user = array();
		if(mysqli_num_rows($set) > 0 ) {
		 	$user = mysqli_fetch_array($set, MYSQLI_ASSOC);
		}else {
			redirect_to('admin/list_user.php');
		}
	}else{
		redirect_to('admin/list_user.php');
	}

	include('../includes/backend/header-admin.php');
	?>

	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-11" style="margin-left: 4.1%">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $user['first_name'] ." ". $user['last_name']  ?></h2>
                            <h4 style="text-align: center" ><a href="index.php"><?= $lang['ADD_USER_LINK_HOME']?></a> / <a href="list_user.php"><?= $lang['ADD_USER_LINK_LIST'] ?></a></h4>
                        </div> <!-- END PANEL HEADING-->

                        <div class="panel-body">
                            <div class="row"  class="show-fontsize">
					            <div class="show-img col-md-11" style="margin-left: 4% ;">
									<div class="panel panel-success">
				                        <div class="show-fontsize panel-heading">
				                            <strong><?= $lang['TABLE_AVATAR']?> : </strong>
				                        </div>
				                        <div class="panel-body">
                                            <img class="img-responsive" style="height: 23vw" src="../images/avatar/<?= $user['avatar'] ?>" alt="<?= $user['avatar'] ?>">
				                        </div>
				                    </div>
                            	</div>
								<!-- END HEADER PANEL -->

                                <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong>User ID :  </strong> <?= $user['user_id'] ?>
					                </div>
					            </div>

					            <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_USERNAME']?> : </strong> <?= $user['username'] ?>
					                </div>
					            </div>

					            <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_TITLE']?> : </strong> <?= $user['email'] ?>
					                </div>
					            </div>

					            <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_DOB']?> : </strong> <?= $user['date_of_birth']?>
					                </div>
					            </div>

					            <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_GENDER'] ?> : </strong> <?= $user['gender'] ?>
					                </div>
					            </div>
					            <div class="col-md-11" style="margin-left: 43.75px">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_WEB'] ?> : </strong> <?= $user['website'] ?>
					                </div>
					            </div>
					            <div class="col-md-11" style="margin-left: 43.75px">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_LVL']?> : </strong>
                                        <?php if ($user['status'] == 9){
                                            echo "Admin";
                                        }else{
                                            echo "Member";
                                        } ?>
					                </div>
					            </div>

								<div class="col-md-11" style="margin-left: 43.75px">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_REG'] ?> : </strong> <?= $user['registration_date'] ?>
					                </div>
					            </div>

                                <div class="col-md-11" style="margin-left: 43.75px">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_STATUS']?> : </strong>
                                        <?php if ($user['status'] == 0){
                                            echo "Inactive";
                                        }else{
                                            echo "Active";
                                        } ?>
					                </div>
					            </div>

                            	<div class="col-md-12">
                            		<center>
                            			<div class="alert alert-default">
                                            <input type="button" class="btncustom btn btn-danger" onclick="window.history.back();" value="<?= $lang['BUTTON_BACK'] ?>">
						                </div>
                            		</center>
					            </div>

      						</div>
                        </div> <!-- END PANEL BODY-->
                    </div> <!-- END PANEL -->
    			</div>
    		</div> <!--  END ROW-->
		</div>
	</div>  <!-- END CONTENT -->

<?php include('../includes/backend/footer-admin.php'); ?>