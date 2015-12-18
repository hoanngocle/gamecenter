<!--#####################################################################
    #
    #   File          : LIST TYPE
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
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
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">List Type</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
    <!-- ============================== Table TYPE [start] ============================== -->
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
                                        // get TYPE in DB
										$result = get_type();
										if(mysqli_num_rows($result) > 0 ) {
									 		while($list = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        ?>
						 				<tr>
							                <td style='text-align:center' ><?= $list['type_id'] ?></td>
							                <td style='text-align:left'><?= $list['cat_name'] ?></td>
							                <td style='text-align:left'><?= $list['type_name'] ?></td>
										</tr>
                                    <?php }	// END WHILE loop
										} else {
                                    ?>
									 	<p class='alert alert-warning'><?= $error_list_user_no_item ?></p>
									<?php 	} // END IF   ?>
							    	</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
    <!-- ============================== Table TYPE [end] ============================== -->
    			</div>
    		</div>
		</div>
	</div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>