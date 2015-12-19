<!--#####################################################################
    #
    #   File          : LIST TAG
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    $title_page = 'List Tag';
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
                    <h1 class="page-head-line"><?= $lang['ADD_TAG_LINK_LIST']?></h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
    <!-- ============================== Table News [start] ============================== -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $lang['ADD_TAG_LINK_LIST']?></h2>
                            <h4 style="text-align: center" ><a href="index.php"><?= $lang['ADD_TAG_LINK_HOME']?></a></h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" style="text-align:center">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th style="width: 10% ; text-align:center"><?= $lang['TABLE_ID'] ?></th>
							    			<th style="width: 20% ; text-align:center"><?= $lang['TABLE_KEYWORD'] ?></th>
							    			<th style="width: 10% ; text-align:center"> </th>
                                        </tr>
                                    </thead>

                                    <tbody>
									<?php
										$result = get_tag();
										if(mysqli_num_rows($result) > 0 ) {
											while($list = mysqli_fetch_array($result, MYSQLI_ASSOC)){
									?>
						 				<tr>
							                <td style='text-align:center' ><?= $list['tag_id'] ?></td>
							                <td style='text-align:left'><?= $list['keyword'] ?></td>
							                <td style='width : 100px'>

								                <a class='btn-action fa fa-pencil' style='text-decoration: none' href='edit_tag.php?tid=<?= $list['tag_id'] ?>'></a>
											</td>
										</tr>

                                    <?php } // END While loop
										} else {
                                    ?>
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
<?php include('../includes/backend/footer-admin.php'); ?>