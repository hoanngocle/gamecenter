<!--#####################################################################
    #
    #   File          : LIST USER
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    $title_page = 'List User';
    include('../includes/functions.php');
	include('../includes/backend/header-admin.php');
	include('../includes/backend/mysqli_connect.php');
    include('../includes/errors.php');

    if ($_SESSION['user_level'] != 99){
        redirect_to('admin/404.php');
    }
?>
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['ADD_USER_LINK_LIST']?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
    <!-- ============================== Table USER [start] ============================== -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $lang['ADD_USER_LINK_LIST']?></h2>
                            <h4 style="text-align: center" ><a href="index.php"><?= $lang['ADD_USER_LINK_HOME']?></a></h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" style="text-align:center">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th style="width: 4% ; text-align:center"><a href="list_user.php?sort=id"><?= $lang['TABLE_ID']?></a></th>
							    			<th style="width: 10% ; text-align:center"><a href="list_user.php?sort=user"><?= $lang['TABLE_USERNAME']?></a></th>
							    			<th style="width: 10% ; text-align:center"><a href="list_user.php?sort=name"><?= $lang['TABLE_FULLNAME']?></a></th>
							                <th style="width: 4% ; text-align:center"><a href="list_user.php?sort=gen"><?= $lang['TABLE_GENDER']?></a></th>
							                <th style="width: 6% ; text-align:center"><a href="list_user.php?sort=ava"><?= $lang['TABLE_AVATAR']?></a></th>
                                            <th style="width: 10% ; text-align:center"><a href="list_user.php?sort=bio"><?= $lang['TABLE_BIO']?></a></th>
                                            <th style="width: 10% ; text-align:center"><a href="list_user.php?sort=dob"><?= $lang['TABLE_DOB']?></a></th>
							                <th style="width: 5% ; text-align:center"><a href="list_user.php?sort=lvl"><?= $lang['TABLE_LVL']?></a></th>
							                <th style="width: 6% ; text-align:center"><a href="list_user.php?sort=reg"><?= $lang['TABLE_REG']?></a></th>
                                            <th style="width: 5% ; text-align:center"><?= $lang['TABLE_STATUS']?></th>
							                <th style="width: 5% ; text-align:center"><?= $lang['TABLE_VIEW']?></th>
                                        </tr>
                                    </thead>

                                    <tbody>
									<?php
										// Sort by head table
										if(isset($_GET['sort'])){
											switch ($_GET['sort']) {
												case 'id':
													$order_by = 'user_id';
													break;

												case 'user':
													$order_by = 'username';
													break;

												case 'name':
													$order_by = 'name';
													break;

												case 'gen':
													$order_by = 'gender';
													break;

												case 'ava':
													$order_by = 'avatar';
													break;

                                                case 'bio':
                                                    $order_by = 'bio';
                                                    break;

                                                case 'dob':
                                                    $order_by = 'birthday';
                                                    break;

                                                case 'lvl':
                                                    $order_by = 'user_level';
                                                    break;

                                                case 'reg':
                                                    $order_by = 'registration_date';
                                                    break;

												default:
													$order_by = 'user_id';
													break;

											} // END Switch
										} else {
											$order_by = 'user_id';
										}

										$result = get_list_user($order_by);
										if(mysqli_num_rows($result) > 0 ) {
										 	while($list = mysqli_fetch_array($result, MYSQLI_ASSOC)){
	                                            // write a column
	                                            if($list['status'] == 0){
	                                                $active = "<a class='btn-action fa fa-remove' href='#' style='text-decoration: none' onClick='change_status_user({$list['user_id']},{$list['status']})'></a>";                                            }else {
	                                                $active = "<a class='btn-action fa fa-check' href='#' style='text-decoration: none' onClick='change_status_user({$list['user_id']},{$list['status']})'></a>";
	                                            }
                                        ?>
							 				<tr>
								                <td style='text-align:right' ><?= $list['user_id'] ?></td>
								                <td style='text-align:left'><?= $list['username'] ?></td>
								                <td style='text-align:left'><?= $list['name'] ?></td>
								                <td style='text-align:justify'><?= $list['gender'] ?></td>
                                                <td style='text-align:left'><img style="height: 135px; width: 135px; margin: auto" src="../images/avatar/<?= $list['avatar'] ?>"></td>
                                                <td style='text-align:left'><?= $list['bio'] ?></td>
                                                <td style='text-align:left'><?= $list['birthday'] ?></td>
                                                <td style='text-align:left'><?= $list['user_level'] ?></td>
								                <td style='text-align:right'><?= $list['date'] ?></td>
                                                <td style='text-align:center'><?= $active ?></td>
								                <td style='width : 100px'>
								                <a class='fa fa-eye' href='show_user.php?nid=<?= $list['user_id'] ?>' style='font-size: 20px; margin-left: 5px; text-decoration: none'></a>
								                </td>
											</tr>

                                    <?php }// END While loop
										} else {
                                    ?>
									 	<p class='alert alert-warning'><?= $error_list_user_no_item ?></p>
									<?php 	}   ?>
							    	</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
    <!-- ============================== Table USER [end] ============================== -->
    			</div>
    		</div>
		</div>
	</div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>