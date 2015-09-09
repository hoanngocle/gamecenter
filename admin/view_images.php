<?php 
	include('../includes/backend/header-admin.php');
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');
?>

	<!-- Script ################## -->
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Manage Images</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-11" style="margin-left: 48.75px">
                  <!--   Kitchen Sink -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center">Images</h2>
                            <h4 style="text-align: center" ><a href="add_image.php">Upload Images</a></h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" style="text-align:center">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th style="width: 4% ; text-align:center"><a href="view_images.php?sort=id">ID</a></th>
							    			<th style="width: 10% ; text-align:center"><a href="view_images.php?sort=cat">Categories</a></th>
							    			<th style="width: 20% ; text-align:center"><a href="view_images.php?sort=title">Title</a></th>
							                <th style="width: 40% ; text-align:center">Image</th>
							                <th style="width: 12% ; text-align:center"><a href="view_images.php?sort=on">Posted On</a></th>
							                <th style="width: 14% ; text-align:center"> </th>
                                        </tr>
                                    </thead>

                                    <tbody>
									<?php 
										 // Sap xep theo thu tu cua table head
											if(isset($_GET['sort'])){
												switch ($_GET['sort']) {
													case 'id':
														$order_by = 'image_id';
														break;
													
													case 'cat':
														$order_by = 'cat_name';
														break;

													case 'title':
														$order_by = 'title';
														break;

													case 'by':
														$order_by = 'image';
														break;

													case 'on':
														$order_by = 'date';
														break;

													default:
														$order_by = 'image_id';
														break;

												} // END Switch
											} else {
												$order_by = 'image_id';
											}
										// Truy xuat csdl de hien thi category
										$result = get_all_images($order_by);

										if(mysqli_num_rows($result) > 0 ) {

										// vong lap while de hien thi ket qua tu csdl ra
									 	while($images = mysqli_fetch_array($result, MYSQLI_ASSOC)){
									 		// in ra cac cot cua bang
									 		echo "
								 				<tr>
									                <td style='text-align:right' >{$images['image_id']}</td>
									                <td style='text-align:left'>{$images['cat_name']}</td>
									                <td style='text-align:left'>{$images['title']}</td>
									                <td style='text-align:justify'>".excerpt($images['image'])."</td>
									                <td style='text-align:right'>{$images['date']}</td>
									                <td style='width : 100px'>
									                <a class='fa fa-eye' href='show_image.php?iid={$images['image_id']}' style='font-size: 20px; margin-left: 5px'></a>
									                <a class='fa fa-pencil' href='edit_image.php?iid={$images['image_id']}' style='font-size: 20px; margin-left: 5px'></a>
									                <a class='fa fa-trash-o' id='delete' name='delete' href='#' style='font-size: 20px; margin-left: 5px' value='' onClick='check_delete({$images['image_id']});'></a>
									                </td>
												</tr>
									 			";
										 	}// END While loop
										} else {
										 	// Neu khong co page de hien thi, bao loi hoac noi nguoi dung tao page
										 	$messages = "<p class='warning'>There is currently no page to display. Please create a page first!</p>";
										}
									?>
							    	</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
    			</div>
    		</div>
		</div>
	</div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>