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

	<!-- Script ################## -->
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">List User</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
    <!-- ============================== Table News [start] ============================== -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center">List User </h2>
                            <h4 style="text-align: center" ><a href="index.php">Home</a> / <a href="add_news.php">Create News</a></h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" style="text-align:center">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th style="width: 4% ; text-align:center"><a href="list_user.php.php?sort=id">ID</a></th>
							    			<th style="width: 10% ; text-align:center"><a href="list_user.php?sort=user">Username</a></th>
							    			<th style="width: 10% ; text-align:center"><a href="list_user.php?sort=name">Fullname</a></th>
							                <th style="width: 4% ; text-align:center"><a href="list_user.php?sort=gen">Gender</a></th>
							                <th style="width: 6% ; text-align:center"><a href="list_user.php?sort=ava">Avatar</a></th>
                                            <th style="width: 10% ; text-align:center"><a href="list_user.php?sort=bio">Bio</a></th>
                                            <th style="width: 10% ; text-align:center"><a href="list_user.php?sort=dob">Date Of Birth</a></th>
							                <th style="width: 5% ; text-align:center"><a href="list_user.php?sort=lvl">User Level</a></th>
							                <th style="width: 6% ; text-align:center"><a href="list_user.php?sort=reg">Registration Date</a></th>
                                            <th style="width: 5% ; text-align:center">Status</th>
							                <th style="width: 5% ; text-align:center">View</th>
                                        </tr>
                                    </thead>

                                    <tbody>
									<?php 
										 // Sap xep theo thu tu cua table head
											if(isset($_GET['sort'])){
												switch ($_GET['sort']) {
													case 'id':
														$order_by = 'user_id';
														break;

													case 'user':
														$order_by = 'username';
														break;

													case 'name':
														$order_by = 'fullname';
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
                                                        $order_by = 'level';
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
                                                $active = "<a class='fa fa-remove' href='#' style='font-size: 20px; margin-left: 5px; text-decoration: none' onClick='change_status_user({$list['user_id']},{$list['status']})'></a>";                                            }else {
                                                $active = "<a class='fa fa-check' href='#' style='font-size: 20px; margin-left: 5px; text-decoration: none' onClick='change_status_user({$list['user_id']},{$list['status']})'></a>";
                                            }
                                        ?>
								 				<tr>
									                <td style='text-align:right' ><?= $list['user_id'] ?></td>
									                <td style='text-align:left'><?= $list['username'] ?></td>
									                <td style='text-align:left'><?= $list['name'] ?></td>
									                <td style='text-align:justify'><?= $list['gender'] ?></td>
                                                    <td style='text-align:left'><img style="height: 135px; width: 135px; margin: auto" src="../images/<?= $list['avatar'] ?>"></td>
                                                    <td style='text-align:left'><?= $list['bio'] ?></td>
                                                    <td style='text-align:left'><?= $list['birthday'] ?></td>
                                                    <td style='text-align:left'><?= $list['user_level'] ?></td>
									                <td style='text-align:right'><?= $list['date'] ?></td>
                                                    <td style='text-align:center'><?= $active ?></td>
                                                        
									                <td style='width : 100px'>
									                <a class='fa fa-eye' href='show_news.php?nid=<?= $list['user_id'] ?>' style='font-size: 20px; margin-left: 5px; text-decoration: none'></a>									                
									                </td>
												</tr>
									 			
                                    <?php }// END While loop
										} else { 
                                    ?>
                                        <!--Neu khong co page de hien thi, bao loi hoac noi nguoi dung tao page-->
										 	<p class='alert alert-warning'><?= $error_list_user_no_item ?></p>
									<?php 	}   ?>
							    	</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
    <!-- ============================== Table News [end] ============================== -->
    			</div>
    		</div>
		</div>
	</div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>