<!--#####################################################################
    #
    #   File          : LIST IMAGE
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    $title_page = 'Gallery';
    include('../includes/functions.php');
	include('../includes/backend/header-admin.php');
	include('../includes/backend/mysqli_connect.php');
    include('../includes/errors.php');
?>
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['ADD_IMAGE_PAGE_HEADER']?></h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $lang['TITLE_GALLERY']?></h2>
                            <h4 style="text-align: center" ><a href="index.php"><?= $lang['ADD_IMAGE_LINK_HOME']?></a> / <a href="add_image.php"><?= $lang['ADD_IMAGE_H2']?></a></h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" style="text-align:center">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th style="width: 4% ; text-align:center"><a href="list_images.php?sort=id"><?=$lang['TABLE_ID']?></a></th>
							    			<th style="width: 6% ; text-align:center"><a href="list_images.php?sort=cat"><?= $lang['TABLE_TYPE'] ?></a></th>
							    			<th style="width: 25% ; text-align:center"><a href="list_images.php?sort=title"><?= $lang['TABLE_TITLE']?></a></th>
							                <th style="width: 28% ; text-align:center"><?= $lang['TABLE_IMAGE']?></th>
							                <th style="width: 11% ; text-align:center"><a href="list_images.php?sort=by"><?= $lang['TABLE_POST_BY']?></a></th>
                                            <th style="width: 10% ; text-align:center"><a href="list_images.php?sort=on"><?= $lang['TABLE_POST_ON']?></a></th>
                                            <th style="width: 5% ; text-align:center"><?= $lang['TABLE_STATUS']?></th>
							                <th style="width: 10% ; text-align:center"> </th>
                                        </tr>
                                    </thead>

                                    <tbody>
									<?php
											if(isset($_GET['sort'])){
												switch ($_GET['sort']) {
													case 'id':
														$order_by = 'image_id';
														break;

													case 'type':
														$order_by = 'type_name';
														break;

													case 'title':
														$order_by = 'title';
														break;

													case 'by':
														$order_by = 'name';
														break;

                                                    case 'on':
														$order_by = 'date';
														break;

													case 'stt':
														$order_by = 'status';
														break;

													default:
														$order_by = 'image_id';
														break;
												} // END Switch
											} else {
												$order_by = 'image_id';
											}
										$result = get_all_images($order_by);
										if(mysqli_num_rows($result) > 0 ) {
									 	while($images = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                            if($images['status'] == 0){
                                                $active = "<a class='btn-action fa fa-remove' href='#' style='text-decoration: none' onClick='change_status_image({$images['image_id']},{$images['status']})'></a>";
                                            }else {
                                                $active = "<a class='btn-action fa fa-check' href='#' style=' text-decoration: none' onClick='change_status_image({$images['image_id']},{$images['status']})'></a>";
                                            }
                                        ?>
                                            <tr>
                                                <td style='text-align:right' ><?= $images['image_id']?></td>
                                                <td style='text-align:left'><?= $images['type_name']?></td>
                                                <td style='text-align:left'><?= $images['title']?></td>
                                                <td style='text-align:justify'><img class="img-list" src="/images/gallery/<?= $images['image']?>" alt="" class="item-chil-row1" ></td>
                                                <td style='text-align:right'><?= $images['name']?></td>
                                                <td style='text-align:right'><?= $images['date']?></td>
                                                <td style='text-align:center'><?= $active?></td>

                                                <td style='width : 100px'>
                                                <a class='btn-action fa fa-eye' href='show_image.php?iid=<?= $images['image_id']?>' style='text-decoration: none'></a>
                                                <a class='fa fa-pencil' href='edit_image.php?iid=<?= $images['image_id']?>' style='text-decoration: none'></a>
                                                <a class='fa fa-trash-o' id='delete' name='delete' href='#' style='text-decoration: none' onClick='check_delete_image(<?= $images['image_id'] ?>);'></a>
                                                </td>
                                            </tr>

									<?php }// END While loop
										} else {
                                    ?>
										 	<p class='alert alert-warning'><?= $error_image_no_item?></p>
									<?php 	}   ?>
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