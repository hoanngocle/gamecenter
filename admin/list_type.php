<?php
    $title_page = 'List Type';
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
                    <h1 class="page-head-line">List Type</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
    <!-- ============================== Table News [start] ============================== -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center">List Type </h2>
                            <h4 style="text-align: center" ><a href="index.php">Home</a> / <a href="add_type.php">Add Type</a></h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" style="text-align:center">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th style="width: 10% ; text-align:center">ID</th>
							    			<th style="width: 20% ; text-align:center">Categories</th>
							    			<th style="width: 40% ; text-align:center">Type Name</th>
                                        </tr>
                                    </thead>

                                    <tbody>
									<?php 

										// Truy xuat csdl de hien thi category
										$result = get_type();
										if(mysqli_num_rows($result) > 0 ) {

										// vong lap while de hien thi ket qua tu csdl ra
									 	while($list = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        ?>
								 				<tr>
									                <td style='text-align:center' ><?= $list['type_id'] ?></td>
									                <td style='text-align:left'><?= $list['cat_name'] ?></td>
									                <td style='text-align:left'><?= $list['type_name'] ?></td>
                                                        
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